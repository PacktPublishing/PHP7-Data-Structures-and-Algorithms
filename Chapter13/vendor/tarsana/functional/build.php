<?php namespace Tarsana\Functional;
/**
 * This script parses the source files using [dox](https://github.com/tj/dox)
 * and generates the unit tests and documentation files.
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Custom Types:
 *  DoxBlock :: {
 *     tags: [{
 *         type: String,
 *         string: String,
 *         types: [String],
 *         name: String,
 *         description: String
 *         ...
 *     }],
 *     description: {
 *         full: String,
 *         summary: String,
 *         body: String
 *     },
 *     code: String,
 *     ctx: {
 *         type: String,
 *         name: String,
 *         ...
 *     }
 *     isPrivate:
 *     isEvent:
 *     isConstructor:
 *     line:
 *     ignore:
 *  }
 *
 * Block :: {
 *     type: file|function|class|method
 *     name: String // DoxBlock.ctx.name
 *     params: [{type: String, name: String}]
 *     return: String
 *     signatures: [String]
 *     description: String
 *     summary: String
 *     internal: Boolean
 *     ignore: Boolean
 *     code: String
 * }
 *
 * Operation :: {
 *     name: String,
 *     signature: String
 * }
 *
 * Module :: {
 *     path: String
 *     name: String
 *     docsPath: String
 *     testsPath: String
 *     blocks: [Block]
 *     docs: String
 *     tests: String
 *     testsFooter: String
 *     streamOperations: String
 *     streamMethods: String
 * }
 */

/**
 * The entry point.
 *
 * @signature [String] -> IO
 * @param  array $modules
 * @return void
 */
function build_main($modules) {
    build_init_stream_operations();
    each(_f('build_module'), $modules);
    build_close_stream_operations();
}

/**
 * Writes the header of the stream operations file.
 *
 * @signature IO
 * @return void
 */
function build_init_stream_operations() {
    file_put_contents(
        'src/Internal/_stream_operations.php',
        "<?php\n\nuse Tarsana\Functional as F;\n\nreturn F\map(F\apply(F\_f('_stream_operation')), [\n\t['then', 'Function -> Any -> Any', F\_f('_stream_then')],\n"
    );
    file_put_contents(
        'docs/stream-operations.md',
        "# Stream Operations"
    );
}

/**
 * Writes the footer of the stream operations file.
 *
 * @signature IO
 * @return void
 */
function build_close_stream_operations() {
    file_put_contents(
        'src/Internal/_stream_operations.php',
        "\n]);\n", FILE_APPEND
    );
}

/**
 * Extracts the modules files from composer.json.
 *
 * @signature [String]
 * @return array
 */
function get_modules() {
    $composer = json_decode(file_get_contents(__DIR__.'/composer.json'));
    return $composer->autoload->files;
}

/**
 * Generates unit tests and documentation for a module.
 *
 * @signature String -> IO
 * @param  string $path
 * @return void
 */
function build_module($path) {
    apply(process_of([
        'module_of',
        'generate_docs',
        'generate_tests',
        'generate_stream_operations',
        'generate_stream_methods',
        'write_module'
    ]), [$path]);
}

/**
 * Writes the module's docs and tests.
 *
 * @signature Module -> IO
 * @param  object $module
 * @return void
 */
function write_module($module) {
    if ($module->docs) {
        $docsDir  = dirname($module->docsPath);
        if (!is_dir($docsDir))
            mkdir($docsDir, 0777, true);
        file_put_contents($module->docsPath,  $module->docs);
    }
    if ($module->tests) {
        $testsDir = dirname($module->testsPath);
        if (!is_dir($testsDir))
            mkdir($testsDir, 0777, true);
        file_put_contents($module->testsPath, $module->tests);
    }
    if ($module->streamOperations) {
        file_put_contents('src/Internal/_stream_operations.php', $module->streamOperations, FILE_APPEND);
    }
    if ($module->streamMethods) {
        file_put_contents('docs/stream-operations.md', $module->streamMethods, FILE_APPEND);
    }
}

/**
 * Creates a module from a path.
 *
 * @signature String -> Module
 * @param  string $path
 * @return object
 */
function module_of($path) {
    return apply(process_of([
        'fill_name',
        'fill_docs_path',
        'fill_tests_path',
        'fill_blocks'
    ]), [(object)['path' => $path]]);
}

/**
 * Fills the name of the Module based on the path.
 * 'src/xxx/aaa.php' -> 'aaa'
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function fill_name($module) {
    $module->name = apply(pipe(split('/'), last(), split('.'), head()), [$module->path]);
    return $module;
}

/**
 * Fills documentation file path based on source file path.
 * 'src/xxx.php' -> 'docs/xxx.md'
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function fill_docs_path($module) {
    $module->docsPath = replace(['src', '.php'], ['docs', '.md'], $module->path);
    return $module;
}

/**
 * Fills tests file path based on source file path.
 * 'src/xxx.php' -> 'tests/xxxTest.php'
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function fill_tests_path($module) {
    $name = ucfirst(camelCase($module->name));
    $dir = 'tests' . remove(3, dirname($module->path));
    $module->testsPath = "{$dir}/{$name}Test.php";
    return $module;
}

/**
 * Fills the blocks of the Module based on the path.
 *
 * @signature Module -> Module
 * @param  array $module
 * @return array
 */
function fill_blocks($module) {
    $module->blocks = apply(pipe(
        prepend('dox -r < '), // "dox -r < src/...php"
        'shell_exec',         // "[{...}, ...]"
        'json_decode',        // [DoxBlock]
        map(_f('make_block'))
        // sort()
    ), [$module->path]);
    return $module;
}

/**
 * Converts a DoxBlock to a Block.
 *
 * @signature DoxBlock -> Block
 * @param  object $doxBlock
 * @return object
 */
function make_block($doxBlock) {
    $tags = groupBy(get('name'), tags_of($doxBlock));

    $type = 'function';
    if (has('file', $tags)) $type = 'file';
    if (has('class', $tags)) $type = 'class';
    if (has('method', $tags)) $type = 'method';

    $params = map(function($tag){
        $parts = split(' ', get('value', $tag));
        return [
            'type' => $parts[0],
            'name' => $parts[1]
        ];
    }, get('param', $tags) ?: []);

    $return = getPath(['return', 0, 'value'], $tags);
    $signatures = get('signature', $tags);
    if ($signatures)
        $signatures = map(get('value'), $signatures);
    return (object) [
        'type' => $type,
        'name' => getPath(['ctx', 'name'], $doxBlock),
        'params' => $params,
        'return' => $return,
        'signatures' => $signatures,
        'description' => getPath(['description', 'full'], $doxBlock),
        'summary' => getPath(['description', 'summary'], $doxBlock),
        'internal' => has('internal', $tags),
        'ignore' => has('ignore', $tags),
        'stream' => has('stream', $tags)
        // 'code' => get('code', $doxBlock)
    ];
}

/**
 * Returns an array of tags, each having a name and a value.
 *
 * @signature DoxBlock -> [{name: String, value: String}]
 * @param  object $doxBlock
 * @return array
 */
function tags_of($doxBlock) {
    if ($doxBlock->tags)
        return map(function($tag){
            return (object) [
                'name'  => $tag->type,
                'value' => $tag->string
            ];
        }, $doxBlock->tags);
    return [];
}

/**
 * Generates documentation contents for a module.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_docs($module) {
    $module->docs = '';
    if (startsWith('_', $module->name))
        return $module;
    return apply(process_of([
        'generate_docs_header',
        'generate_docs_sommaire',
        'generate_docs_contents'
    ]), [$module]);
}

/**
 * Generates documentation header.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_docs_header($module) {
    $name = $module->name;
    $description = get('description', head($module->blocks));
    $module->docs .= "# {$name}\n\n{$description}\n\n";
    return $module;
}

/**
 * Generates documentation table of contents.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_docs_sommaire($module) {
    $blocks = filter (
        satisfiesAll(['ignore' => not(), 'internal' => not(), 'type' => equals('function')]),
        $module->blocks
    );
    $items = map(_f('generate_docs_sommaire_item'), $blocks);
    $module->docs .= join('', $items);
    return $module;
}

/**
 * Generates an item of the documentation's table of contents.
 *
 * @signature Block -> String
 * @param  object $block
 * @return string
 */
function generate_docs_sommaire_item($block) {
    $title = get('name', $block);
    $link  = lowerCase($title);
    return "- [{$title}](#{$link}) - {$block->summary}\n\n";
}

/**
 * Generates documentation contents.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_docs_contents($module) {
    $blocks = filter (
        satisfiesAll(['ignore' => not(), 'internal' => not()]),
        $module->blocks
    );
    $contents = map(_f('generate_docs_contents_item'), $blocks);
    $module->docs .= join('', $contents);
    return $module;
}

/**
 * Generates an item of the documentation's contents.
 *
 * @signature Block -> String
 * @param  object $block
 * @return string
 */
function generate_docs_contents_item($block) {
    if ($block->type != 'function')
        return '';
    $params = join(', ', map(pipe(values(), join(' ')), get('params', $block)));
    $return = get('return', $block);
    $prototype = "```php\n{$block->name}({$params}) : {$return}\n```\n\n";
    $signature = '';
    $blockSignature = join("\n", $block->signatures);
    if ($blockSignature)
        $signature = "```\n{$blockSignature}\n```\n\n";
    return "# {$block->name}\n\n{$prototype}{$signature}{$block->description}\n\n";
}

/**
 * Generates tests contents for a module.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_tests($module) {
    $module->tests = '';
    $module->testsFooter = '';
    return apply(process_of([
        'generate_tests_header',
        'generate_tests_contents',
        'generate_tests_footer'
    ]), [$module]);
}

/**
 * Generates module's tests header.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_tests_header($module) {
    $namespace = "Tarsana\UnitTests\Functional";
    $additionalNamespace = replace("/", "\\", remove(6, dirname($module->testsPath)));
    if ($additionalNamespace)
        $namespace .= "\\" . $additionalNamespace;
    $name = remove(-4, last(split("/", $module->testsPath)));
    $module->tests .= "<?php namespace {$namespace};\n\nuse Tarsana\Functional as F;\n\nclass {$name} extends \Tarsana\UnitTests\Functional\UnitTest {\n";
    return $module;
}

/**
 * Generates module's tests contents.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_tests_contents($module) {
    $blocks = filter (
        satisfiesAll(['ignore' => not()]),
        $module->blocks
    );
    $contents = join("\n", map(function($block) use($module) {
        return generate_tests_contents_item($block, $module);
    }, $blocks));
    if (trim($contents) != '')
        $module->tests .= $contents;
    else
        $module->tests = '';
    return $module;
}

/**
 * Generates a test for a module.
 *
 * @signature Block -> Module -> String
 * @param  object $block
 * @param  object $module
 * @return string
 */
function generate_tests_contents_item($block, $module) {
    if ($block->type != 'function')
        return '';

    $code = apply(pipe(
        _f('code_from_description'),
        chunks("\"\"''{}[]()", "\n"),
        map(function($part) use($module) {
            return add_assertions($part, $module);
        }),
        filter(pipe('trim', notEq(''))),
        chain(split("\n")),
        map(prepend("\t\t")),
        join("\n")
    ), [$block]);

    if ('' == trim($code))
        return '';
    return prepend("\tpublic function test_{$block->name}() {\n",
        append("\n\t}\n", $code)
    );
}

/**
 * Extracts the code snippet from the description of a block.
 *
 * @signature Block -> String
 * @param  object $block
 * @return string
 */
function code_from_description($block) {
    $description = get('description', $block);
    if (!contains('```php', $description))
        return '';
    $code = remove(7 + indexOf('```php', $description), $description);
    return remove(-4, trim($code));
}

/**
 * Adds assertions to a part of the code.
 *
 * @signature String -> String
 * @param  string $part
 * @return string
 */
function add_assertions($part, $module) {
    if (contains('; //=> ', $part)) {
        $pieces = split('; //=> ', $part);
        $part = "\$this->assertEquals({$pieces[1]}, {$pieces[0]});";
    }
    elseif (contains('; // throws ', $part)) {
        $pieces = split('; // throws ', $part);
        $variables = match('/ \$[0-9a-zA-Z_]+/', $pieces[0]);
        $use = '';
        if (length($variables)) {
            $variables = join(', ', map('trim', $variables));
            $use = "use({$variables}) ";
        }
        return "\$this->assertErrorThrown(function() {$use}{\n\t$pieces[0]; \n},\n{$pieces[1]});";
    }
    elseif (startsWith('class ', $part) || startsWith('function ', $part)) {
        $module->testsFooter .= $part . "\n\n";
        $part = '';
    }
    return $part;
}

/**
 * Generates module's tests footer.
 *
 * @signature Module -> Module
 * @param  object $module
 * @return object
 */
function generate_tests_footer($module) {
    if ($module->tests)
        $module->tests .= "}\n\n{$module->testsFooter}";
    return $module;
}

/**
 * Generates module's stream operations.
 *
 * @signature Module -> Module
 * @param  array $module
 * @return array
 */
function generate_stream_operations($module) {
    $blocks = filter (
        satisfiesAll(['ignore' => equals(false), 'stream' => equals(true)]),
        $module->blocks
    );
    $operations = map(_f('stream_operation_declaration'), chain(_f('stream_operations_of_block'), $blocks));
    $module->streamOperations = join("", $operations);
    return $module;
}

/**
 * Gets stream operations from a block.
 *
 * @signature Block -> [Operation]
 * @param  object $block
 * @return string
 */
function stream_operations_of_block($block) {
    return map(function($signature) use($block) {
        return (object) [
            'name' => $block->name,
            'signature' => normalize_signature($signature)
        ];
    }, get('signatures', $block));
}

/**
 * Converts a formal signature to a stream signature.
 * [a]       becomes List
 * {k: v}    becomes Array|Object
 * (a -> b)  becomes Function
 *  *        becomes Any
 *
 * @signature String -> String
 * @param  string $signature
 * @return string
 */
function normalize_signature($signature) {
    // This is not the best way to do it :P
    return join(' -> ', map(pipe(
        regReplace('/Maybe\([a-z][^\)]*\)/', 'Any'),
        regReplace('/Maybe\(([^\)]+)\)/', '$1|Null'),
        regReplace('/\([^\)]+\)/', 'Function'),
        regReplace('/\[[^\]]+\]/', 'List'),
        regReplace('/\{[^\}]+\}/', 'Object|Array'),
        regReplace('/^.$/', 'Any'),
        regReplace('/[\(\)\[\]\{\}]/', '')
    ), chunks('(){}', ' -> ', $signature)));
}

/**
 * Converts a stream operation to declaration array.
 *
 * @signature Operation -> String
 * @param  object $operation
 * @return string
 */
function stream_operation_declaration($operation) {
    $name = rtrim($operation->name, '_');
    return "\t['{$name}', '{$operation->signature}', F\\{$operation->name}()],\n";
}

/**
 * Generates module's stream methods documentation.
 *
 * @signature Module -> Module
 * @param  array $module
 * @return array
 */
function generate_stream_methods($module) {
    $blocks = filter (
        satisfiesAll(['ignore' => equals(false), 'stream' => equals(true)]),
        $module->blocks
    );
    $methods = map(stream_method_link($module->name), $blocks);
    $module->streamMethods = (length($methods) > 0)
        ? "\n\n## {$module->name}\n\n" . join("\n", $methods)
        : '';
    return $module;
}

/**
 * Gets an element of the stream methods list.
 *
 * @signature String -> Block -> String
 * @param  string $moduleName
 * @param  object $block
 * @return string
 */
function stream_method_link() {
    static $curried = false;
    $curried = $curried ?: curry(function($moduleName, $block) {
        return "- [{$block->name}](https://github.com/tarsana/functional/blob/master/docs/{$moduleName}.md#{$block->name}) - {$block->summary}\n";
    });
    return _apply($curried, func_get_args());
}

/**
 * process_of(['f1', 'f2']) == pipe(_f('f1'), _f('f2'));
 *
 * @signature [String] -> Function
 * @param array $fns
 * @return callable
 */
function process_of($fns) {
    return apply(_f('pipe'), map(_f('_f'), $fns));
}

/**
 * Dump a variable and returns it.
 *
 * @signature a -> a
 * @param  mixed $something
 * @return mixed
 */
function log() {
    $log = function($something) {
        echo toString($something);
        return $something;
    };
    return apply(curry($log), func_get_args());
}

// Convert Warnings to Exceptions
set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    if (0 === error_reporting())
        return false;
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// Run the build
build_main(get_modules());

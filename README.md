# magic-asset
Data encoder/decoder  for a magic asset's file


### Example
```
<?php

use MagicAsset\Vanilla;

$uri =
    (new Vanilla\EncodedFile())
        ->withFile("path/to/file.jpg")
        ->withSecret("someSecret")
        ->withTasks(
            (new Vanilla\TkCollection())
                ->with(
                    (
                    (new Vanilla\TkDumb())->with("foo")
                    )
                )
                ->with(
                    (
                    (new Vanilla\TkDumb())->with("bar")
                    )
                )
                ->with(
                    (
                    (new Vanilla\TkDumb())->with("baz")
                    )
                )
        )
        ->URI();
        
echo "Encoded: {$uri}\n";

$d = (new Vanilla\DecodedURI())
    ->withURI($uri)
    ->withSecret("someSecret")
    ->decoded();
echo "Decoded: {$d->file()}\n\n";

echo "Tasks' result: \n";
$d->tasks()->each(function ($t) {
    $t->execute();
    echo "\n";
});
?>
```

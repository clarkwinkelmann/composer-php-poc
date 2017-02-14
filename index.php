<?php

require_once 'vendor/autoload.php';

use App\ComposerCommands;
use App\ComposerPackages;

$message = '';

switch ($_GET['a']) {
    case 'update':
        $message = ComposerCommands::update();
        break;
    case 'dumpautoload':
        $message = ComposerCommands::dumpautoload();
        break;
    default:
        if (array_key_exists('require', $_GET)) {
            // This is of course very dangerous
            $message = ComposerCommands::require($_GET['require']);
        } else if (array_key_exists('remove', $_GET)) {
            $message = ComposerCommands::remove($_GET['remove']);
        }
}

$packages = ComposerPackages::index();

?>

<?php if (!empty($message)): ?>
<pre><?= htmlspecialchars($message) ?></pre>
<?php endif; ?>

<ul>
    <?php foreach ($packages as $package => $version): ?>
    <li><?= $package ?> (<?= $version ?>) <a href="?remove=<?= urlencode($package) ?>">remove</a></li>
    <?php endforeach; ?>
</ul>

<form action="." method="get">
    <input type="text" value="" name="require" placeholder="vendor/package">
    <button type="submit">Install</button>
</form>

<ul>
    <li><a href="?a=update">Composer update</a></li>
    <li><a href="?a=dumpautoload">Dump autoload</a></li>
    <li><a href=".">Back</a></li>
</ul>

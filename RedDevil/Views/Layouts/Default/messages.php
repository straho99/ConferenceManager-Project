<?php
if (isset($_SESSION['messages'])) {
    echo '<ul class="messages-container" id="messages-container">';
    foreach ($_SESSION['messages'] as $msg) {
        if ($msg['text'] == null) {
            echo '</ul>';
            return;
        }
        echo '<li class="' . $msg['type'] . '">';
        echo htmlspecialchars($msg['text']);
        echo '</li>';
    }
    echo '</ul>';
    unset($_SESSION['messages']);
}
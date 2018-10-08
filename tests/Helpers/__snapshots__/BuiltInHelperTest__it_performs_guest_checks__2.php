<?php return '<div><div>
    <div>
        This will always be visible
    </div>
    <div class="wrapper">
        <?php if(auth()->guard()->guest()): ?> <div>
            This will always be visible
        </div> <?php endif; ?>
    </div>

</div></div>';

<?php

return '<div><div>
    <div>
        <a href="<?php echo e(route(\'route_with_parameters\', [1, 2])); ?>">This will link to a route</a>
    </div>
</div></div>';

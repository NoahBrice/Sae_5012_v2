<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerK8PpJYH\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerK8PpJYH/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerK8PpJYH.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerK8PpJYH\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerK8PpJYH\App_KernelDevDebugContainer([
    'container.build_hash' => 'K8PpJYH',
    'container.build_id' => '08059b72',
    'container.build_time' => 1704890020,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerK8PpJYH');

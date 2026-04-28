


<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    'alignment' => 'center',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'subtitle' => null,
    'alignment' => 'center',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $alignmentClass =
        $alignment === 'center'
            ? 'text-center'
            : ($alignment === 'left' ? 'text-left' : 'text-right');

    $subtitleWidthClass = $alignment === 'center' ? 'mx-auto' : '';
?>

<div class="mb-12 <?php echo e($alignmentClass); ?>">
    <h2 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-theme-text">
        <span class="text-brand-accent"><?php echo e($title); ?></span>
    </h2>

    <?php if($subtitle): ?>
        <p class="mt-4 text-theme-muted text-lg md:text-xl font-light max-w-4xl <?php echo e($subtitleWidthClass); ?>">
            <?php echo e($subtitle); ?>

        </p>
    <?php endif; ?>
</div><?php /**PATH C:\Users\MC\Desktop\ضروري\vertex_system\resources\views/components/section-title.blade.php ENDPATH**/ ?>
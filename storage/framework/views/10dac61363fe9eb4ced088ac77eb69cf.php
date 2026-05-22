<?php $__env->startSection('title','Certificate Templates'); ?>
<?php $__env->startSection('page-title','Certificate Templates'); ?>
<?php $__env->startSection('page-subtitle','Manage reusable certificate designs'); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('admin.templates.create')); ?>" class="btn-primary text-sm">+ New Template</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
    <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card p-5 flex flex-col">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="font-semibold text-gray-800"><?php echo e($template->name); ?></h3>
                <p class="text-xs text-gray-400 mt-0.5"><?php echo e(ucfirst($template->type)); ?> &bull; <?php echo e(ucfirst($template->border_style)); ?> border</p>
            </div>
            <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($template->is_active ? 'badge-verified' : 'bg-gray-100 text-gray-500'); ?>">
                <?php echo e($template->is_active ? 'Active' : 'Inactive'); ?>

            </span>
        </div>
        <p class="text-xs text-gray-500 mb-3">Created by <?php echo e($template->creator->name ?? '—'); ?> &bull; <?php echo e($template->created_at->format('d M Y')); ?></p>
        <p class="text-xs text-gray-400 mb-4"><?php echo e($template->certificates()->count()); ?> certificates issued using this template</p>

        <div class="mt-auto flex gap-2">
            <a href="<?php echo e(route('admin.templates.preview', $template)); ?>" target="_blank"
                class="flex-1 text-center px-3 py-1.5 border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-gray-50 transition">
                👁 Preview
            </a>
            <a href="<?php echo e(route('admin.templates.edit', $template)); ?>"
                class="flex-1 text-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-100 transition">
                ✏ Edit
            </a>
            <?php if($template->certificates()->count() === 0): ?>
            <form method="POST" action="<?php echo e(route('admin.templates.delete', $template)); ?>" onsubmit="return confirm('Delete this template?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition">🗑</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="md:col-span-3 text-center py-16 text-gray-400">
        <p class="text-4xl mb-3">🎨</p>
        <p>No templates yet.</p>
        <a href="<?php echo e(route('admin.templates.create')); ?>" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Create your first template →</a>
    </div>
    <?php endif; ?>
</div>
<?php echo e($templates->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/templates/index.blade.php ENDPATH**/ ?>
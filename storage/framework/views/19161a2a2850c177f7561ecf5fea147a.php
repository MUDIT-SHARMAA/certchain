<?php $__env->startSection('title','Events'); ?>
<?php $__env->startSection('page-title','Events'); ?>
<?php $__env->startSection('page-subtitle','Manage college events for certificate issuance'); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('events.create')); ?>" class="btn-primary text-sm">+ Create Event</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card p-5 flex flex-col">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-900/10 flex items-center justify-center text-xl">
                <?php
                $icons = ['Workshop'=>'🔧','Seminar'=>'🎤','Competition'=>'🏆','Hackathon'=>'💻','Symposium'=>'🎓','Cultural'=>'🎭','Sports'=>'⚽'];
                echo $icons[$event->event_type] ?? '📅';
                ?>
            </div>
            <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($event->status === 'active' ? 'bg-green-100 text-green-700' : ($event->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600')); ?>">
                <?php echo e(ucfirst($event->status)); ?>

            </span>
        </div>

        <h3 class="font-semibold text-gray-800 mb-1 leading-tight"><?php echo e($event->name); ?></h3>
        <p class="text-xs text-gray-500 mb-1"><?php echo e($event->event_type); ?> &bull; <?php echo e($event->department ?? 'All Departments'); ?></p>
        <p class="text-xs text-gray-400 mb-3">📅 <?php echo e($event->event_date?->format('d M Y')); ?>

            <?php if($event->event_end_date): ?> – <?php echo e($event->event_end_date?->format('d M Y')); ?> <?php endif; ?>
            <?php if($event->venue): ?> &bull; 📍 <?php echo e($event->venue); ?> <?php endif; ?>
        </p>

        <?php if($event->description): ?>
        <p class="text-xs text-gray-500 mb-3 line-clamp-2"><?php echo e($event->description); ?></p>
        <?php endif; ?>

        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500">
                📜 <?php echo e($event->certificates->count()); ?> certificate<?php echo e($event->certificates->count() !== 1 ? 's' : ''); ?>

            </span>
            <div class="flex gap-2">
                <a href="<?php echo e(route('certificates.create')); ?>?event_id=<?php echo e($event->id); ?>" class="text-xs text-blue-600 hover:underline">Issue</a>
                <a href="<?php echo e(route('events.edit', $event)); ?>" class="text-xs text-gray-500 hover:underline">Edit</a>
                <?php if($event->certificates->count() === 0): ?>
                <form method="POST" action="<?php echo e(route('events.destroy', $event)); ?>" onsubmit="return confirm('Delete this event?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="text-xs text-red-400 hover:underline">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="md:col-span-3 card p-12 text-center">
        <p class="text-4xl mb-3">📅</p>
        <p class="text-gray-600 font-medium">No events yet</p>
        <p class="text-gray-400 text-sm mt-1 mb-4">Create your first event to start issuing certificates</p>
        <a href="<?php echo e(route('events.create')); ?>" class="btn-primary inline-block text-sm">+ Create Event</a>
    </div>
    <?php endif; ?>
</div>

<div class="mt-5"><?php echo e($events->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Desktop/certchain/resources/views/faculty/events/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Admin Dashboard'); ?>
<?php $__env->startSection('page-title','Admin Dashboard'); ?>
<?php $__env->startSection('page-subtitle','System overview and blockchain status'); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('certificates.create')); ?>" class="btn-primary text-sm">+ Issue Certificate</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <?php
    $statCards = [
        ['label'=>'Total Users',       'value'=>$stats['total_users'],        'icon'=>'👥', 'color'=>'blue'],
        ['label'=>'Events',            'value'=>$stats['total_events'],        'icon'=>'📅', 'color'=>'purple'],
        ['label'=>'Certificates',      'value'=>$stats['total_certificates'],  'icon'=>'📜', 'color'=>'green'],
        ['label'=>'Blockchain Blocks', 'value'=>$stats['total_blocks'],        'icon'=>'⛓',  'color'=>'yellow'],
        ['label'=>'Emails Sent',       'value'=>$stats['emails_sent'],         'icon'=>'📧', 'color'=>'teal'],
        ['label'=>'Revoked',           'value'=>$stats['revoked'],             'icon'=>'🚫', 'color'=>'red'],
    ];
    ?>
    <?php $__currentLoopData = $statCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card p-5">
        <p class="text-2xl mb-2"><?php echo e($card['icon']); ?></p>
        <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format($card['value'])); ?></p>
        <p class="text-xs text-gray-500 mt-1"><?php echo e($card['label']); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card p-5 mb-6 flex items-center gap-4 <?php echo e($chainStatus['valid'] ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500'); ?>">
    <span class="text-3xl"><?php echo e($chainStatus['valid'] ? '✅' : '🚨'); ?></span>
    <div class="flex-1">
        <p class="font-semibold text-gray-800">Blockchain Chain Integrity: 
            <span class="<?php echo e($chainStatus['valid'] ? 'text-green-600' : 'text-red-600'); ?>">
                <?php echo e($chainStatus['valid'] ? 'VALID & INTACT' : 'COMPROMISED'); ?>

            </span>
        </p>
        <p class="text-sm text-gray-500"><?php echo e($chainStatus['total_blocks']); ?> blocks in chain
            <?php if(!$chainStatus['valid']): ?> — <?php echo e(count($chainStatus['errors'])); ?> error(s) detected <?php endif; ?>
        </p>
    </div>
    <a href="<?php echo e(route('admin.blockchain')); ?>" class="btn-primary text-sm">View Ledger</a>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Recent Certificates</h3>
            <a href="<?php echo e(route('certificates.index')); ?>" class="text-xs text-blue-600 hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentCertificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate"><?php echo e($cert->student_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($cert->certificate_id); ?> &bull; <?php echo e($cert->event->name ?? 'N/A'); ?></p>
                </div>
                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($cert->status === 'issued' ? 'badge-verified' : 'badge-revoked'); ?>">
                    <?php echo e(ucfirst($cert->status)); ?>

                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-400 text-center py-4">No certificates issued yet.</p>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Certificates This Year</h3>
        <div class="space-y-2">
            <?php
            $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $max = max(array_values($monthlyStats) ?: [1]);
            ?>
            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $count = $monthlyStats[$i+1] ?? 0; $width = $max > 0 ? round(($count/$max)*100) : 0; ?>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-400 w-7"><?php echo e($month); ?></span>
                <div class="flex-1 bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all" style="width:<?php echo e($width); ?>%"></div>
                </div>
                <span class="text-xs text-gray-500 w-6 text-right"><?php echo e($count); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
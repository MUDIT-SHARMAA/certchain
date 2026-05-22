<?php $__env->startSection('title','Certificate Details'); ?>
<?php $__env->startSection('page-title','Certificate Details'); ?>
<?php $__env->startSection('page-subtitle', $certificate->certificate_id); ?>

<?php $__env->startSection('header-actions'); ?>
<a href="<?php echo e(route('certificates.download', $certificate)); ?>" class="btn-primary text-sm">⬇ Download PDF</a>
<?php if(!$certificate->email_sent): ?>
<form method="POST" action="<?php echo e(route('certificates.email', $certificate)); ?>" class="inline">
    <?php echo csrf_field(); ?>
    <button class="btn-gold text-sm ml-2">📧 Send Email</button>
</form>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid lg:grid-cols-3 gap-6">

    
    <div class="lg:col-span-2 space-y-5">

        
        <?php if($verification['valid']): ?>
        <div class="flex items-center gap-4 p-4 bg-green-50 border border-green-200 rounded-xl">
            <div class="text-4xl">✅</div>
            <div>
                <p class="font-bold text-green-800">BLOCKCHAIN VERIFIED</p>
                <p class="text-sm text-green-600">This certificate is authentic and recorded on the blockchain ledger.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="flex items-center gap-4 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="text-4xl">🚨</div>
            <div>
                <p class="font-bold text-red-800"><?php echo e($verification['status']); ?></p>
                <p class="text-sm text-red-600"><?php echo e($verification['message']); ?></p>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card p-6">
            <h3 class="font-semibold text-gray-800 mb-4">🎓 Student Information</h3>
            <div class="grid md:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                <?php
                $fields = [
                    'Student Name'      => $certificate->student_name,
                    'Enrollment No.'    => $certificate->enrollment_number,
                    'Email'             => $certificate->student_email,
                    'Branch'            => $certificate->student_branch ?? '—',
                    'Year'              => $certificate->student_year ?? '—',
                    'Achievement'       => $certificate->achievement,
                    'Issued Date'       => $certificate->issued_date?->format('d M Y'),
                    'Issued By'         => $certificate->issuer->name ?? '—',
                ];
                ?>
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5"><?php echo e($label); ?></p>
                    <p class="font-medium text-gray-800"><?php echo e($value); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($certificate->description): ?>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400 mb-1">Description</p>
                <p class="text-sm text-gray-700"><?php echo e($certificate->description); ?></p>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="card p-6">
            <h3 class="font-semibold text-gray-800 mb-4">📅 Event Information</h3>
            <div class="grid md:grid-cols-2 gap-y-4 text-sm">
                <div><p class="text-xs text-gray-400 mb-0.5">Event Name</p><p class="font-medium"><?php echo e($certificate->event->name); ?></p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Event Type</p><p class="font-medium"><?php echo e($certificate->event->event_type); ?></p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Date</p><p class="font-medium"><?php echo e($certificate->event->event_date?->format('d M Y')); ?></p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Venue</p><p class="font-medium"><?php echo e($certificate->event->venue ?? '—'); ?></p></div>
            </div>
        </div>
    </div>

    
    <div class="space-y-5">

        
        <div class="card p-5 text-center">
            <p class="text-xs text-gray-400 mb-2">Certificate Status</p>
            <span class="px-4 py-1.5 rounded-full font-semibold text-sm <?php echo e($certificate->status === 'issued' ? 'badge-verified' : 'badge-revoked'); ?>">
                <?php echo e(strtoupper($certificate->status)); ?>

            </span>
            <?php if($certificate->email_sent): ?>
            <p class="text-xs text-gray-400 mt-2">📧 Email sent <?php echo e($certificate->email_sent_at?->diffForHumans()); ?></p>
            <?php endif; ?>
        </div>

        
        <?php if($block = $certificate->blockchainBlock): ?>
        <div class="card p-5 blockchain-node text-white">
            <p class="text-xs text-white/50 mb-3 uppercase tracking-widest">Blockchain Block #<?php echo e($block->block_index); ?></p>
            <div class="space-y-3 text-xs font-mono">
                <div>
                    <p class="text-white/40">Block Hash</p>
                    <p class="text-yellow-300 break-all"><?php echo e($block->block_hash); ?></p>
                </div>
                <div>
                    <p class="text-white/40">Previous Hash</p>
                    <p class="text-white/70 break-all"><?php echo e(substr($block->previous_hash, 0, 32)); ?>...</p>
                </div>
                <div>
                    <p class="text-white/40">Data Hash</p>
                    <p class="text-green-300 break-all"><?php echo e(substr($block->data_hash, 0, 32)); ?>...</p>
                </div>
                <div>
                    <p class="text-white/40">Mined At</p>
                    <p class="text-white/70"><?php echo e($block->mined_at?->format('d M Y H:i:s')); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="card p-5 text-center">
            <p class="text-xs text-gray-500 mb-2">Public Verification Link</p>
            <a href="<?php echo e(route('verify.certificate', $certificate->certificate_id)); ?>" target="_blank"
                class="text-xs text-blue-600 break-all hover:underline">
                <?php echo e(route('verify.certificate', $certificate->certificate_id)); ?>

            </a>
        </div>

        
        <?php if($certificate->status === 'issued'): ?>
        <div class="card p-5">
            <h4 class="font-semibold text-red-700 text-sm mb-3">⚠ Revoke Certificate</h4>
            <form method="POST" action="<?php echo e(route('certificates.revoke', $certificate)); ?>" onsubmit="return confirm('Are you sure you want to revoke this certificate?')">
                <?php echo csrf_field(); ?>
                <textarea name="reason" required placeholder="Reason for revocation…" rows="2"
                    class="w-full border border-red-200 rounded-lg px-3 py-2 text-xs mb-2 resize-none focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                <button class="w-full py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">Revoke Certificate</button>
            </form>
        </div>
        <?php elseif($certificate->status === 'revoked'): ?>
        <div class="card p-5 border-l-4 border-red-400">
            <p class="text-sm font-semibold text-red-700">Revocation Reason</p>
            <p class="text-xs text-red-600 mt-1"><?php echo e($certificate->revoke_reason); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/certificates/show.blade.php ENDPATH**/ ?>
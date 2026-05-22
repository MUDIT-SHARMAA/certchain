<?php $__env->startSection('title','My Profile'); ?>
<?php $__env->startSection('page-title','My Profile'); ?>
<?php $__env->startSection('page-subtitle','Update your information and signature'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
<form method="POST" action="<?php echo e(route('faculty.profile.update')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<div class="space-y-5">
    <div class="card p-6">
        <div class="flex items-center gap-5 mb-6 pb-5 border-b border-gray-100">
            <div class="w-16 h-16 rounded-2xl bg-blue-900/10 text-blue-900 flex items-center justify-center text-2xl font-bold">
                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

            </div>
            <div>
                <p class="font-semibold text-gray-800 text-lg"><?php echo e($user->name); ?></p>
                <p class="text-gray-500 text-sm"><?php echo e($user->email); ?></p>
                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-medium"><?php echo e(ucfirst($user->role_name)); ?></span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Designation</label>
                <input type="text" name="designation" value="<?php echo e(old('designation', $user->designation)); ?>" placeholder="e.g. Assistant Professor"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                <input type="text" name="department" value="<?php echo e(old('department', $user->department)); ?>"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-1">Signature Image</h3>
        <p class="text-xs text-gray-500 mb-4">Upload your signature (PNG/JPG, max 1MB). This appears on issued certificates.</p>
        <?php if($user->signature_path): ?>
        <div class="mb-3 p-3 bg-gray-50 rounded-lg inline-block">
            <p class="text-xs text-gray-400 mb-1">Current Signature:</p>
            <img src="<?php echo e(asset('storage/' . $user->signature_path)); ?>" alt="Signature" class="h-12">
        </div>
        <?php endif; ?>
        <input type="file" name="signature" accept="image/png,image/jpeg"
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-800 mb-1">Change Password</h3>
        <p class="text-xs text-gray-500 mb-4">Leave blank to keep your current password.</p>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                <input type="password" name="password" minlength="8"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">Save Changes</button>
    </div>
</div>
</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/faculty/profile.blade.php ENDPATH**/ ?>
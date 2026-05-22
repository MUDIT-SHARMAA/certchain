<?php $__env->startSection('title','Create Event'); ?>
<?php $__env->startSection('page-title','Create Event'); ?>
<?php $__env->startSection('page-subtitle','Add a new college event for certificate issuance'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
<form method="POST" action="<?php echo e(route('events.store')); ?>">
<?php echo csrf_field(); ?>
<div class="space-y-5">
    <div class="card p-6">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="e.g. National Tech Symposium 2024"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Type <span class="text-red-500">*</span></label>
                <select name="event_type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select type…</option>
                    <?php $__currentLoopData = ['Workshop','Seminar','Competition','Hackathon','Symposium','Cultural','Sports','Webinar','Conference','Training','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(old('event_type') === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                <input type="text" name="department" value="<?php echo e(old('department', auth()->user()->department)); ?>" placeholder="e.g. Computer Science"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                <input type="date" name="event_date" value="<?php echo e(old('event_date')); ?>" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">End Date</label>
                <input type="date" name="event_end_date" value="<?php echo e(old('event_end_date')); ?>"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Venue</label>
                <input type="text" name="venue" value="<?php echo e(old('venue')); ?>" placeholder="e.g. Main Auditorium, Block A"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Brief description of the event…"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="btn-primary">Create Event</button>
        <a href="<?php echo e(route('events.index')); ?>" class="px-5 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
    </div>
</div>
</form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbook/Documents/Dtop/certchain/resources/views/faculty/events/create.blade.php ENDPATH**/ ?>
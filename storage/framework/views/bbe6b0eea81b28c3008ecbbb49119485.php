
<?php $__env->startSection('page-heading', 'Create Timesheet'); ?>

<?php $__env->startSection('content'); ?>

<div class="mx-auto space-y-6">

<?php if($errors->any()): ?>
    <div class="rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
        <ul class="list-disc pl-5">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($err); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <div class="border-b border-gray-100 px-6 py-5">
        <h1 class="text-xl font-semibold text-gray-900">Create Timesheet</h1>
        <p class="text-sm text-gray-500">Capture your shift details for payroll review.</p>
    </div>

    <form method="POST" action="<?php echo e(route('staff.timesheets.store')); ?>" class="space-y-5 px-6 py-6">
        <?php echo csrf_field(); ?>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700" for="date">Date</label>
            <input type="date" name="date" id="date"
                   value="<?php echo e(old('date')); ?>"
                   class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700" for="client_id">Client / Site</label>
            <select name="client_id" id="client_id"
                    class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                <option value="">Select Client</option>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($client->id); ?>" <?php if(old('client_id') == $client->id): echo 'selected'; endif; ?>>
                        <?php echo e($client->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-1">
                <label class="text-sm font-semibold text-gray-700" for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time"
                       value="<?php echo e(old('start_time')); ?>"
                       class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
            </div>
            <div class="space-y-1">
                <label class="text-sm font-semibold text-gray-700" for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time"
                       value="<?php echo e(old('end_time')); ?>"
                       class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       required>
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700" for="break_minutes">Break (minutes)</label>
            <input type="number" name="break_minutes" id="break_minutes"
                   value="<?php echo e(old('break_minutes')); ?>"
                   class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="e.g. 30">
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700" for="total_hours">Total Hours</label>
            <input type="text" id="total_hours"
                   class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-gray-900 shadow-inner"
                   readonly>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700" for="notes">Notes</label>
            <textarea name="notes" id="notes" rows="4"
                      class="w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Optional context for reviewer"><?php echo e(old('notes')); ?></textarea>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-700">
                Submit Timesheet
            </button>
        </div>
    </form>
</div>

</div>

<script>
function calculateHours() {
    let start = document.getElementById("start_time").value;
    let end = document.getElementById("end_time").value;
    let breakTime = parseInt(document.getElementById("break_minutes").value || 0);

    if (start && end) {
        let s = new Date("2024-01-01 " + start);
        let e = new Date("2024-01-01 " + end);

        let diff = (e - s) / 1000 / 60; // in minutes
        diff -= breakTime;

        document.getElementById("total_hours").value = (diff / 60).toFixed(2);
    }
}

document.querySelectorAll("#start_time, #end_time, #break_minutes")
    .forEach(el => el.addEventListener("input", calculateHours));
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\digitizal\Downloads\staff_portal\resources\views/staff/timesheets/create.blade.php ENDPATH**/ ?>
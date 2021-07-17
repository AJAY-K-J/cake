<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Date</th>
            <th>Expense Category</th>
            <th>Expense Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e(Carbon\Carbon::parse($expense->created_at)->format('d-M-Y H:i:s')); ?></td>
                <td><?php echo e($expense->expensecategory); ?></td>
                <td><?php echo e($expense->name); ?></td>
                <td><?php echo e($expense->amount); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\cake\resources\views/exports/expense_report.blade.php ENDPATH**/ ?>
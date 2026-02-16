<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
    });
</script>
<style>
/* ── Task Details Modal — Improved Table ── */
.af-task-detail-header { padding: 0 0 14px; }
.af-task-detail-header h5 { font-size: 1.1rem; font-weight: 700; color: #2c3e50; margin: 0 0 6px; }
.af-task-detail-header .af-task-desc { font-size: .88rem; color: #555; line-height: 1.6; }

.af-subtask-legend { display: flex; align-items: center; gap: 18px; margin-bottom: 14px; font-size: .82rem; color: #555; }
.af-subtask-legend span { display: inline-flex; align-items: center; gap: 5px; }

.af-subtask-table { width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #e8ebf0; border-radius: 10px; overflow: hidden; }
.af-subtask-table thead th {
    background: #f5f6fa; color: #485b79; font-weight: 600; font-size: .82rem;
    padding: 10px 14px; border-bottom: 2px solid #e0e3ea; white-space: nowrap; text-transform: uppercase; letter-spacing: .3px;
}
.af-subtask-table tbody td {
    padding: 10px 14px; font-size: .85rem; color: #333; border-bottom: 1px solid #f0f1f5; vertical-align: top;
}
.af-subtask-table tbody tr:last-child td { border-bottom: none; }
.af-subtask-table tbody tr:hover td { background: #fafbfd; }

/* Fixed column widths so Label & Description always show */
.af-subtask-table .af-col-label { width: 22%; min-width: 120px; font-weight: 600; color: #2c3e50; }
.af-subtask-table .af-col-desc { width: 33%; min-width: 160px; }
.af-subtask-table .af-col-status { width: 45%; }

/* Status user chips */
.af-status-chips { display: flex; flex-wrap: wrap; gap: 6px; }
.af-status-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px; font-size: .78rem; font-weight: 500;
    white-space: nowrap; line-height: 1.3;
}
.af-status-chip.completed { background: #e6f9f0; color: #1a8a5a; }
.af-status-chip.not-completed { background: #fef3f0; color: #c0392b; }
.af-status-chip .af-chip-dot {
    display: inline-block; width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
}
.af-status-chip.completed .af-chip-dot { background: #27ae60; }
.af-status-chip.not-completed .af-chip-dot { background: #e74c3c; }
</style>
<?php $todayDate = strtotime(date('Y-m-d'));?>
<div class="">
    <input type="hidden" id="taskRedirectSts" value="0" />
    <div class="af-task-detail-header">
        <h5><?php echo $taskDetailsArr['taskName'];?></h5>
        <?php if(isset($taskDetailsArr['taskDesc']) && $taskDetailsArr['taskDesc']!=''){?>
           <div class="af-task-desc"><?php echo $taskDetailsArr['taskDesc'];?></div>
        <?php } ?>
    </div>
    <?php if(count($subTaskDataArr)>0){ ?>
        <div class="af-subtask-legend">
            <span><label class="tskLegSts completed"></label> Task Completed</span>
            <span><label class="tskLegSts notStarted"></label> Not Completed</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="af-subtask-table">
                <thead>
                    <tr>
                        <th class="af-col-label">Label</th>
                        <th class="af-col-desc">Short Description</th>
                        <th class="af-col-status">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($subTaskDataArr as $subTask){ ?>
                    <tr>
                        <td class="af-col-label"><?php echo $subTask['staskLbl'];?></td>
                        <td class="af-col-desc"><?php echo $subTask['staskDesc'];?></td>
                        <td class="af-col-status">
                            <div class="af-status-chips">
                                <?php foreach($assignedProTaskDataArr as $au){ 
                                    $res = filter_array_two($completedTaskUserDataArr,$au['userId'],'userId',$subTask['subTaskId'],'subTaskId');
                                    $isCompleted = count($res)>0;
                                ?>
                                <span class="af-status-chip <?php echo $isCompleted ? 'completed' : 'not-completed'; ?>">
                                    <span class="af-chip-dot"></span>
                                    <?php echo $au['userName']; ?>
                                </span>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
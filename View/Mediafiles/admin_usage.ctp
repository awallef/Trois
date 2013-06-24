<div class="index">
    <h2>Utilisation</h2>

    <table class="table table-bordered table-striped" >
        
        <tr>
            <th>Type</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
        
        <tr>
            <td>
                File Count
            </td>
            <td>
                <?php echo $filesCount; ?>
            </td>
            <td></td>
        </tr>

        <tr>
            <td>
                Files Usage
            </td>
            <td>
                <?php echo $this->Storage->format_size($filesUsage); ?>
                ( ~ <?php echo $this->Storage->format_size($fileAverage); ?> each )
            </td>
            <td></td>
        </tr>

        <tr>
            <td>
                Cache Usage
            </td>
            <td>
                <?php echo $this->Storage->format_size($cacheUsage); ?>
            </td>
            <td><a href="<?php echo $this->Html->url(array('action' => 'clearcache')); ?>"<button class="btn btn-primary">Clear cache</button></td>
        </tr>

        <tr>
            <td>
                Disk Usage
            </td>
            <td>
                <?php echo $this->Storage->format_size($filesUsage + $cacheUsage); ?>
            </td>
            <td></td>
        </tr>
        
        <tr>
            <td>
                Disk Space Left
            </td>
            <td>
                <?php echo $this->Storage->format_size(disk_free_space("/")); ?>
            </td>
            <td></td>
        </tr>

    </table>

</div>
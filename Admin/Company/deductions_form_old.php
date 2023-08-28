</div><!-- /.row -->
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Add New Deductions</h3>
        </div>
        <div class="box-body">
            <!-- Date range -->
            <form method="post" action="#add_" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="date">Name</label>
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control pull-right" id="date" name="name" placeholder="Deduction name" required>
                    </div>
                </div>


                <div class="form-group">
                    <label for="date">Type</label>
                    <div class="input-group col-md-12">
                        <select class="form-control" name="type">
                            <option value="Fixed"> Fixed </option>
                            <option value="Calculated"> Calculated </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date">Status</label>
                    <div class="input-group col-md-12">
                        <select class="form-control" name="status">
                            <option value="Active"> Active </option>
                            <option value="Not Active"> Not Active </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date">Percentage of: </label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group col-md-12">
                                <input class="form-control" name="percent" type="number">
                            </div>
                        </div>
                        <div class="col-md-2">
                            % of
                        </div>
                        <div class="col-md-6">
                            <div class="input-group col-md-12">
                                <select class="form-control" name="percent_of">
                                    <option value="gross pay"> Gross Pay </option>
                                    <option value="basic pay"> Basic Pay </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-primary" id="daterange-btn" name="add_">
                            Save
                        </button>
                        <button class="btn" id="daterange-btn">
                            Clear
                        </button>
                    </div>
                </div><!-- /.form group -->
        </div>
        </form>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col (right) -->

<!-- update form -->
<form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>

    <div class="form-group">
        <label for="name">Name</label>
        <div class="input-group col-md-12">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['ded_id']; ?>" required>
            <input type="text" class="form-control pull-right" id="date" name="name" value="<?php echo $row['name'] ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label for="date">Type</label>
        <div class="input-group col-md-12">
            <select class="form-control" name="type">
                <option value="<?php echo $row['type']; ?>"> <?php echo $row['type']; ?> </option>
                <option value="Fixed"> Fixed </option>
                <option value="Calculated"> Calculated </option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="date">Status</label>
        <div class="input-group col-md-12">
            <select class="form-control" name="status">
                <option value="<?php echo $row['status']; ?>"> <?php echo $row['status']; ?> </option>
                <option value="Active"> Active </option>
                <option value="Not Active"> Not Active </option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="date">Percentage of: </label>
        <div class="row">
            <div class="col-md-3">
                <div class="input-group col-md-12">
                    <input class="form-control" value="<?php echo $row['status']; ?>" name="percent" type="number">
                </div>
            </div>
            <div class="col-md-2">
                % of
            </div>
            <div class="col-md-7">
                <div class="input-group col-md-12">
                    <select class="form-control" name="percent_of">
                        <option value="<?php echo $row['status']; ?>"> </option>
                        <option value="gross pay"> Gross Pay </option>
                        <option value="basic pay"> Basic Pay </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
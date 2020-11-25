<div id="fedex-label-history" style="">
    <div>
        <h1 class="page-header text-overflow">Fedex Labels</h1>
    </div>
    <div class="bootstrap-table">
        <div class="fixed-table-container">
            <div class="fixed-table-body">
                <div class="fixed-table-loading" style="top: 37px;">Loading, please wait…</div>
                <table id="demo-table" class="table table-striped table-hover" data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true">
                    <thead>
                        <tr>
                            <th style=""><div class="th-inner ">Sl No</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Tracking No.</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Pdf Label</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Charges</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Tracking Type</div><div class="fht-cell"></div></th>
                            <th style=""><div class="th-inner ">Created</div><div class="fht-cell"></div></th>
                        </tr>
                    </thead>
                    <tbody id="fedex-label-content"><?php 
                     //   $fedexLabelHistory =   $this->crud_model->getFedexLabelHistory($row['sale_code']);
                        $n = 0;
                        foreach ($fedexLabelHistory as $fedexs){ 
                            $fedex  =   (object) $fedexs;   ?>
                            <tr data-index="<?php echo $n?>"><?php $n++;?>
                                <td style=""><?php echo $n ?></td>
                                <td style=""><?php echo $fedex->tracking_no ?></td>
                                <td style="">
                                    <a href="<?php echo base_url('fedex/labels/'.$fedex->pdf_label) ?>" title="Click to view" target="_blank">
                                        <?php echo $fedex->pdf_label ?>
                                    </a>
                                </td>
                                <td style=""><?php echo $fedex->net_charge ?></td>
                                <td style=""><?php echo $fedex->tracking_type ?></td>
                                <td style=""><?php echo $fedex->created ?></td>
                            </tr><?php 
                        } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
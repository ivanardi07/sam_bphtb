<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
if (count($list_history) > 0) {
?>
    <table class="table table-hover">
        <thead>
            <tr class="tblhead">
                <th class="text-center"> Tahun Pajak SPPT </th>
                <th class="text-center"> PBB Yang Harus Dibayar</th>
                <th class="text-center"> Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_history as $key => $value) : ?>
                <tr>
                    <td class="text-center"> <?= $value->THN_PAJAK_SPPT ?> </td>
                    <td class="text-right"> <?= formatrupiah($value->PBB_YG_HARUS_DIBAYAR_SPPT) ?> </td>
                    <td class="text-center"> <?= $value->STATUS ?> </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php } else { ?>
    <b>Belum ada history pembayaran</b>
<?php }
?>
<h2 id="page_title">
    All your orders
</h2>
<?php foreach($orders as $order) : ?>
<div id="cart_info">
    <p><?php echo lang('shop.invoice_num_label').$order->id; ?></p>
    <p><?php echo lang('shop.cart_date'). ': ' .$order->date; ?></p>
</div>



<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

    <tr>
      <th><?php echo lang('shop.qty_label'); ?></th>
      <th><?php echo lang('shop.item_title_label'); ?></th>
      <th style="text-align:right"><?php echo lang('shop.item_price_label'); ?></th>
      <th style="text-align:right"><?php echo lang('shop.sub_total_label'); ?></th>
    </tr>

    <?php $sum = 0; ?>

    <?php foreach ($order->items as $item): ?>

          <?php  $sum += $item->price * $item->qty; ?>

            <tr>
              <td><?php echo $item->qty; ?></td>
              <td><?php echo $item->name; ?></td>
              <td style="text-align:right"><?php echo $item->price; ?></td>
              <td style="text-align:right"><?php echo $sum; ?></td>
            </tr>

    <?php endforeach; ?>

    <tr>
      <td colspan="2"> </td>
      <td class="right"><strong><?php echo lang('shop.total_label'); ?></strong></td>
      <td class="right"><?php echo $sum; ?></td>
    </tr>

</table>
<?php endforeach; ?>
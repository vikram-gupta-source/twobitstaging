<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $location;
?>
<!-- Modal -->
<?php if (!empty($location)) : ?>
<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="map-modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title"><?php echo $location['address'];?>, <?php echo $location['city'];?>,<?php echo $location['state_abrv'];?><br><a href="tel:<?php echo cleanPhone($location['phone']);?>"><?php echo $location['phone'];?></a>
          <?php if (!empty($location['days'])) :?>
          <div class="map-hrs roboto mt-2">
            <?php foreach ($location['days'] as $days) :?>
              <div class="days text-uppercase"><?php echo $days['day'];?>: <?php echo (!empty($days['open'])) ? $days['open'] .' - ' .  $days['close'] : 'Closed for Reboot'; ?></div>
            <?php endforeach ?>
            <?php if(!empty($location['message'])) :?>
            <div class="mt-2"><?php echo $location['message'];?></div>
            <?php endif ?>
          </div>
          <?php endif ?>
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (!empty($location['google_map_iframe'])) : ?>
        <div id="map" style="height:400px;">
          <?php echo $location['google_map_iframe'];?>
        </div>
        <div class="directions">
          <div class="text-content text-center flex-content">
            <a class="map-link car" href="<?php echo $location['driving_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-car" aria-hidden="true"></i></a>
            <a class="map-link bus" href="<?php echo $location['bus_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-bus" aria-hidden="true"></i></a>
            <a class="map-link walk" href="<?php echo $location['walking_map_link'];?>" target="_blank" rel="noopener"><svg aria-hidden="true" data-prefix="fas" data-icon="walking" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-walking fa-w-10"><path fill="currentColor" d="M208 96c26.5 0 48-21.5 48-48S234.5 0 208 0s-48 21.5-48 48 21.5 48 48 48zm94.5 149.1l-23.3-11.8-9.7-29.4c-14.7-44.6-55.7-75.8-102.2-75.9-36-.1-55.9 10.1-93.3 25.2-21.6 8.7-39.3 25.2-49.7 46.2L17.6 213c-7.8 15.8-1.5 35 14.2 42.9 15.6 7.9 34.6 1.5 42.5-14.3L81 228c3.5-7 9.3-12.5 16.5-15.4l26.8-10.8-15.2 60.7c-5.2 20.8.4 42.9 14.9 58.8l59.9 65.4c7.2 7.9 12.3 17.4 14.9 27.7l18.3 73.3c4.3 17.1 21.7 27.6 38.8 23.3 17.1-4.3 27.6-21.7 23.3-38.8l-22.2-89c-2.6-10.3-7.7-19.9-14.9-27.7l-45.5-49.7 17.2-68.7 5.5 16.5c5.3 16.1 16.7 29.4 31.7 37l23.3 11.8c15.6 7.9 34.6 1.5 42.5-14.3 7.7-15.7 1.4-35.1-14.3-43zM73.6 385.8c-3.2 8.1-8 15.4-14.2 21.5l-50 50.1c-12.5 12.5-12.5 32.8 0 45.3s32.7 12.5 45.2 0l59.4-59.4c6.1-6.1 10.9-13.4 14.2-21.5l13.5-33.8c-55.3-60.3-38.7-41.8-47.4-53.7l-20.7 51.5z" class=""></path></svg></a>
            <a class="map-link bike" href="<?php echo $location['bike_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-bicycle" aria-hidden="true"></i></a></div></div>
        </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

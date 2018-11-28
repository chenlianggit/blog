<?php global $salong; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="keywords" content="<?php echo $salong['keywords']; ?>">
  <meta name="description" content="<?php echo $salong['description']; ?>">
  <title><?php bloginfo('name'); ?></title>
	<style>
		.my-map .icon { background: url(https://lbs.amap.com/console/public/show/marker.png) no-repeat; }
		.my-map .icon-flg { height: 32px; width: 29px; }
		.my-map .icon-flg-red { background-position: -65px -5px; }
		.amap-container{height: 100%;}
	</style>
</head>
<body>
	<div id="wrap" class="my-map" data-snap-ignore="true">
		<div id="mapContainer"></div>
	</div>
	<script src="https://webapi.amap.com/maps?v=1.3&key=8325164e247e15eea68b59e89200988b"></script>
    <script><?php echo $salong['map_js']; ?></script>
</body>
</html>
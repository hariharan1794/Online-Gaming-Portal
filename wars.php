<!DOCTYPE html>
<html>
	<?php include('header.php'); ?>
  <link rel="stylesheet" type="text/css" href="css/stl.css">

	<body>
		<?php include('sidebar.php'); ?>
		<div class="container">
      <div id="Controls" align="center">Controls :: Use &larr; and &rarr; to move left and right. Use &uarr; and &darr; to move cannon anticlockwise and clockwise.<br> Press (Space) to shoot.</div>
      <div id="Player1Score">0</div>
      <div id="Player2Score">0</div>
      <div id="PlayerTeam">Waiting to connect</div>
      <div id="WhoseTurn">Waiting to connect</div>
      <canvas id="testCanvas" width="1000" height="500"></canvas>


				<div id="options" class="hidden">
					<div class="align-left">
						<button name="close" type="submit"><i class="fa fa-home"></i></button>
					</div>
					<div class="align-right">
						<input name="email" type="text" value="" />
						<button name="invite" type="submit" value="">Invite</button>
					</div>
				</div>
			</div>

			<?php include('share.php'); ?>
		</div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.4.4.min.js"></script>
      <script type="text/javascript" src="js/ap.js"></script>
		<?php include('footer.php'); ?>
	</body>
</html>

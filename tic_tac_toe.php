<!DOCTYPE html>
<html>
	<?php include('header.php'); ?>
	<body>
		<?php include('sidebar.php'); ?>
		<div class="container">
			<div class="game">
				<div id="intro" class="center hidden">
					<h2>Name:</h2>
					<input type="text" name="name" />
					<h2>Email:</h2>
					<input type="text" name="email" />
					<h2>Select:</h2>
					<?php if(isset($_GET['invite'])): ?>
						<button type="button" name="sign">Start Game</button>
					<?php else: ?>
						<button type="button" class="player_sign" name="sign" value="X">X</button>
						<button type="button" class="player_sign" name="sign" value="O">O</button>
					<?php endif; ?>
				</div>
				<div id="board" class="center hidden">
					<table>
						<tr>
							<td>
								<button class="cell empty" id="cell_00" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_01" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_02" type="button"></button>
							</td>
						</tr>
						<tr>
							<td>
								<button class="cell empty" id="cell_10" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_11" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_12" type="button"></button>
							</td>
						</tr>
						<tr>
							<td>
								<button class="cell empty" id="cell_20" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_21" type="button"></button>
							</td>
							<td>
								<button class="cell empty" id="cell_22" type="button"></button>
							</td>
						</tr>
					</table>
					<div class="show_result hidden">
						<h3>Game Over</h3>
						<p></p>
					</div>
				</div>
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
			<div class="right-sidebar hidden">
				<h3>Players</h3>
				<div id="users">
				</div>
				<hr/>
				<h3>Spectators</h3>
				<div id="spectators">

				</div>
			</div>
			<?php include('share.php'); ?>
		</div>
		<?php include('footer.php'); ?>
	</body>
</html>

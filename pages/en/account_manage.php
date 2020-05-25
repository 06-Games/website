<div style="height: 100%; display: flex;">
	<div class="side-menu" style="display: flex; flex-direction: column;">
		<button href="#global" class="active">Global</button>
		<button href="#profile">Profile</button>
		<button href="#external">Linked Accounts</button>
		<button href="#library">Library</button>
		<div style="flex: 1;"></div>
		<button onclick="Cookies.remove('account'); changeMenu('#Account');">Logout</button>
		<div class="openBtn">></div>
	</div>
	<div class="side-content">
		<div>
			<div id="global">
				<h3>Global</h3>
				<hr>
			</div>
			<div id="profile">
				<h3>Profile</h3>
				<hr>
			</div>
			<div id="external">
				<h3>Linked Accounts</h3>
				<hr>
			</div>
			<div id="library">
				<h3>Library</h3>
				<hr>
			</div>
		</div>
	</div>
</div>
<script>
	registerSideMenu(".side-content");
</script>
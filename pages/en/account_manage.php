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
				<h2>Global</h2>
				<hr>
			</div>
			<div id="profile">
				<h2>Profile</h2>
				<hr>
			</div>
			<div id="external">
				<h2>Linked Accounts</h2>
				<hr>
			</div>
			<div id="library">
				<h2>Library</h2>
				<hr>
			</div>
		</div>
	</div>
</div>
<script>
	registerSideMenu(".side-content");
</script>
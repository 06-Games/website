<div style="height: 100%; display: flex;">
	<div class="side-menu" style="display: flex; flex-direction: column;">
		<button href="#global" class="active">General</button>
		<button href="#profile">Profil</button>
		<button href="#external">Comptes liés</button>
		<button href="#library">Bibliothèque</button>
		<div style="flex: 1;"></div>
		<button onclick="Cookies.remove('account'); changeMenu('#Account');">Se déconnecter</button>
		<div class="openBtn">></div>
	</div>
	<div class="side-content">
		<div>
			<div id="global">
				<h3>General</h3>
				<hr>
			</div>
			<div id="profile">
				<h3>Profil</h3>
				<hr>
			</div>
			<div id="external">
				<h3>Comptes liés</h3>
				<hr>
			</div>
			<div id="library">
				<h3>Bibliothèque</h3>
				<hr>
			</div>
		</div>
	</div>
</div>
<script>
	registerSideMenu(".side-content");
</script>
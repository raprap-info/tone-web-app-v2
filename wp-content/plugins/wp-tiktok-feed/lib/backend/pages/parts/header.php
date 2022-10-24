<div class="wrap about-wrap full-width-layout">

	<h1><?php echo esc_html( QLTTF_PLUGIN_NAME ); ?></h1>

	<p class="about-text"><?php printf( esc_html__( 'Thanks for using %s! We are doing our best to offer you the best alternatives to display TikTok videos on your site, helping you to improve communication experience with your users.', 'wp-tiktok-feed' ), QLTTF_PLUGIN_NAME ); ?></p>

	<p class="about-text">
		<?php printf( '<a href="%s" target="_blank">%s</a>', QLTTF_PURCHASE_URL, esc_html__( 'Premium', 'wp-tiktok-feed' ) ); ?></a> |
		<?php printf( '<a href="%s" target="_blank">%s</a>', QLTTF_DEMO_URL, esc_html__( 'Demo', 'wp-tiktok-feed' ) ); ?></a> |
		<?php printf( '<a href="%s" target="_blank">%s</a>', QLTTF_DOCUMENTATION_URL, esc_html__( 'Documentation', 'wp-tiktok-feed' ) ); ?></a>
	</p>

	<?php
	printf(
		'<a href="%s" target="_blank"><div style="
							 background: #006bff url(%s) no-repeat;
							 background-position: top center;
							 background-size: 130px 130px;
							 color: #fff;
							 font-size: 14px;
							 text-align: center;
							 font-weight: 600;
							 margin: 5px 0 0;
							 padding-top: 120px;
							 height: 40px;
							 display: inline-block;
							 width: 140px;
							 " class="wp-badge">%s</div></a>',
		'https://quadlayers.com/?utm_source=qlttf_admin',
		plugins_url( '/assets/backend/img/quadlayers.jpg', QLTTF_PLUGIN_FILE ),
		esc_html__( 'QuadLayers', 'wp-tiktok-feed' )
	);
	?>

</div>
<?php
if ( isset( $submenu[ QLTTF_DOMAIN ] ) ) {
	if ( is_array( $submenu[ QLTTF_DOMAIN ] ) ) {
		?>
		<div class="wrap about-wrap full-width-layout">
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $submenu[ QLTTF_DOMAIN ] as $tab ) {
					if ( strpos( $tab[2], '.php' ) !== false ) {
						continue;
					}
					?>
					<a href="<?php echo admin_url( 'admin.php?page=' . esc_attr( $tab[2] ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && $_GET['page'] == $tab[2] ) ? ' nav-tab-active' : ''; ?>"><?php echo wp_kses_post( $tab[0] ); ?></a>
					<?php
				}
				?>
			</h2>
		</div>
		<?php
	}
}

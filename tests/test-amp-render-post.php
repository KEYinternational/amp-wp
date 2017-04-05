<?php

class AMP_Render_Post_Test extends WP_UnitTestCase {
	public function test__invalid_post() {
		// No ob here since it bails early
		$amp_rendered = amp_render_post( PHP_INT_MAX );

		$this->assertFalse( $amp_rendered );
		$this->assertEquals( 0, did_action( 'pre_amp_render_post' ) );
	}

	public function test__valid_post() {
		$post_id = $this->factory->post->create();

		// Need to use ob here since the method echos
		ob_start();
		amp_render_post( $post_id );
		$amp_rendered = ob_get_clean();

		$this->assertStringStartsWith( '<html amp>', $amp_rendered );
		$this->assertEquals( 1, did_action( 'pre_amp_render_post' ) );
	}
}

<?php
/**
 * Provide a public area view for the plugin
 *
 * @since 1.0.0
 * @package woofcrate-subscribe
 * @author Gogo
 */

defined( 'WPINC' ) || exit;
?>

<section id="woSuWrap">
	<div id="woSuStep"></div>
	<div id="woSu">
		<h3><?php esc_html_e( 'Subscription Start', 'woofsubs' ) ?></h3>
		<section class="sections text-center wosu-header">
			<?php if ( 'gift' === $mode ) : ?>
			<h3 class="title">Looking for a pawesome gift for a friend?</h3>
			<p class="separator-wrapper margin-center">
				<span class="separator"></span>
			</p>
			<p class="description"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['giftstart'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => 0,
				]
			), $allowed_html ) ?></p>
			<div id="subsGift" class="choices">
				<a id="gotoGif" href="#" class="yesno"><?php esc_html_e( 'Gift a Crate', 'woofsubs' ) ?></a>
				&nbsp;
				<a id="gotoSub" href="<?php echo esc_url( $sub_url ) ?>" class="yesno"><?php esc_html_e( 'Subscribe', 'woofsubs' ) ?></a>
			</div>
			<?php endif ?>
		</section>
		<h3><?php esc_html_e( 'Tell us a bit about your dog!', 'woofsubs' ) ?></h3>
		<section class="sections text-center">
			<nav>
				<button disabled class="hidden" data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php
				// translators: %s => dog name
				printf( esc_html__( 'Tell us a bit about %s!', 'woofsubs' ), '<span class="dog-name">' . esc_html( $dog_name ) . '</span>' );
			?></h3>
			<div class="section-img margin-center">
				<?php echo wp_get_attachment_image( (int) $woofsubs['images']['doginfo'], 'full' ) . "\n" ?>
			</div>
			<div class="inputs-group margin-center">
				<div class="input">
					<label for="dogName"><?php esc_html_e( 'Name', 'woofsubs' ) ?></label>
					<input id="dogName" name="dog_name" type="text" required>
				</div>
				<div class="input">
					<label for="dogMOB"><?php esc_html_e( 'Birthday', 'woofsubs' ) ?></label>
					<input id="dogMOB" name="dog_mob" type="date" required>
				</div>
				<div class="input-radio">
					<label><?php esc_html_e( 'Gender', 'woofsubs' ) ?></label>
					<div class="input-radio-item">
						<input id="dgMale" name="dog_gender" type="radio" value="<?php esc_attr_e( 'Male', 'woofsubs' ) ?>">
						<label for="dgMale"><?php esc_html_e( 'Male', 'woofsubs' ) ?></label>
					</div>
					<div class="input-radio-item">
						<input id="dgFemale" name="dog_gender" type="radio" value="<?php esc_attr_e( 'Female', 'woofsubs' ) ?>">
						<label for="dgFemale"><?php esc_html_e( 'Female', 'woofsubs' ) ?></label>
					</div>
				</div>
			</div>
			<p class="section-err"></p>
		</section>
		<h3><?php esc_html_e( 'What size is your dog?', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button disabled class="hidden" data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php
				// translators: %s => dog name
				printf( esc_html__( 'What size is %s?', 'woofsubs' ), '<span class="dog-name">' . esc_html( $dog_name ) . '</span>' );
			?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogsize'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => 0,
				]
			), $allowed_html ) ?></p>
			<div id="size" class="series of-<?php echo count( $dog_sizes ) ?>">
			<?php foreach ( $dog_sizes as $size ) : ?>
				<div class="boxes full-width" data-slug="<?php echo esc_attr( $size->slug ) ?>" data-id="<?php echo esc_attr( $size->term_id ) ?>">
					<div>
						<h4><?php echo esc_html( $size->name ) ?></h4>
						<figure>
							<?php echo wp_get_attachment_image( (int) get_term_meta( $size->term_id, 'image_id', true ), 'woocommerce_single' ) . "\n" ?>
							<figcaption></figcaption>
						</figure>
					</div>
				</div>
			<?php endforeach ?>
			</div>
			<p class="section-err"></p>
		</section><!-- #woofSubs2 -->
		<h3><?php esc_html_e( 'Does your dog have any allergies?', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php
				// translators: %s => dog name
				printf( esc_html__( 'Does %s have any allergies?', 'woofsubs' ), '<span class="dog-name">' . esc_html( $dog_name ) . '</span>' );
			?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogallergy'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => 0,
				]
			), $allowed_html ) ?></p>
			<div class="section-img margin-center">
				<?php echo wp_get_attachment_image( (int) $woofsubs['images']['dogallergy'], 'full' ) . "\n" ?>
			</div>
			<div id="allergy" class="choices">
				<a id="haveAllergy" href="#" class="yesno"><?php esc_html_e( 'Yes', 'woofsubs' ) ?></a>
				<a id="noAllergy" href="#" class="yesno"><?php esc_html_e( 'No', 'woofsubs' ) ?></a>
			</div>
			<div class="desc-wrapper hide">
				<div class="inputs-group margin-center">
					<div class="input">
						<label for="descAllergy"><?php esc_html_e( 'Allergy', 'woofsubs' ) ?></label>
						<textarea id="descAllergy" name="desc_allergy" rows="2" placeholder="<?php esc_attr_e( 'Describe the dog\'s allergy here...', 'woofsubs' ) ?>"></textarea>
					</div>
				</div>
			</div>
			<p class="section-err"></p>
		</section>
		<h3><?php esc_html_e( 'Which crate does your dog want?', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button disabled class="hidden" data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php
				// translators: %s => dog name
				printf( esc_html__( 'Which crate does %s want?', 'woofsubs' ), '<span class="dog-name">' . esc_html( $dog_name ) . '</span>' );
			?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogcrate'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => 0,
				]
			), $allowed_html ) ?></p>
			<div id="crates" class="series of-<?php echo count( $crates ) ?>">
			<?php foreach ( $crates as $k => $v ) : ?>
				<div class="boxes full-width" data-slug="<?php echo esc_attr( $k ) ?>" data-id="<?php echo esc_attr( $v[0] ) ?>" data-variations="<?php echo esc_attr( $v[4] ) ?>">
					<div>
						<h4><?php echo esc_html( $v[1] ) ?></h4>
						<figure>
							<?php echo $v[2] !== 0 ? wp_get_attachment_image( $v[2], 'woocommerce_single' ) . "\n" : '' ?>
							<figcaption><?php echo esc_html( $v[3] ) ?></figcaption>
						</figure>
					</div>
				</div>
			<?php endforeach ?>
			</div>
			<div class="desc-wrapper hide">
				<div class="inputs-group margin-center">
					<div class="input">
						<label for="descCrate"><?php esc_html_e( 'Allergy', 'woofsubs' ) ?></label>
						<textarea id="descCrate" name="desc_crate" rows="2"></textarea>
					</div>
				</div>
			</div>
			<p class="section-err"></p>
		</section>
		<h3><?php esc_html_e( 'Select your plan!', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button disabled class="hidden" data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php esc_html_e( 'Select your plan!', 'woofsubs' ) ?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogplan'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => 0,
				]
			), $allowed_html ) ?></p>
			<div id="plans" class="series">
			<?php foreach ( $plans as $plan ) : ?>
				<div class="boxes full-width" data-slug="<?php echo esc_attr( $plan->slug ) ?>" data-id="<?php echo esc_attr( $plan->term_id ) ?>">
					<div>
						<h4><?php echo esc_html( $plan->name ) ?></h4>
						<figure>
							<?php echo wp_get_attachment_image( (int) get_term_meta( $plan->term_id, 'image_id', true ), 'woocommerce_single' ) . "\n" ?>
							<figcaption></figcaption>
						</figure>
					</div>
				</div>
			<?php endforeach ?>
			</div>
			<p class="section-err"></p>
		</section>
		<h3><?php esc_html_e( 'Double Trouble!', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php esc_html_e( 'Double Trouble!', 'woofsubs' ) ?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogdoutro'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => $dou_tro[1],
				]
			), $allowed_html ) ?></p>
			<div id="doubleTrouble" class="series">
				<div class="boxes full-width">
					<div class="no-border margin-center">
						<figure>
							<?php echo wp_get_attachment_image( $dou_tro[2], 'woocommerce_single' ) . "\n" ?>
							<figcaption></figcaption>
						</figure>
					</div>
				</div>
			</div>
			<div id="isDouble" class="checkbox">
				<i class="far fa-circle"></i>
			</div>
			<p class="section-err"></p>
		</section>
		<h3><?php esc_html_e( 'Add an extra toy!', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php esc_html_e( 'Add an extra toy!', 'woofsubs' ) ?></h3>
			<p class="section-desc"><?php echo wp_kses( woofsubs_po(
				$woofsubs['messages']['dogxtoy'],
				[
					'dogname' => $dog_name,
					'currency' => $currency,
					'nominal' => $woofsubs['extratoy_price'],
				]
			), $allowed_html ) ?></p>
			<div id="extraToy" class="series">
				<div class="boxes full-width">
					<div class="no-border smaller-content margin-center">
						<figure>
							<?php echo wp_get_attachment_image( (int) $woofsubs['images']['dogxtoy'], 'woocommerce_single' ) . "\n" ?>
							<figcaption></figcaption>
						</figure>
					</div>
				</div>
			</div>
			<div id="isAddToy" class="checkbox">
				<i class="far fa-circle"></i>
			</div>
			<p class="section-err"></p>
		</section>
		<?php if ( 'gift' === $mode ) : ?>
		<h3><?php esc_html_e( 'Personalize the Box', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot">
			<nav>
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#n"><i class="fas fa-arrow-right"></i></button>
			</nav>
			<h3><?php esc_html_e( 'Personalize the Box', 'woofsubs' ) ?></h3>
			<div class="inputs-group margin-center">
				<div class="input">
					<label for="rcpeName"><?php esc_html_e( 'Recipients Name', 'woofsubs' ) ?></label>
					<input id="rcpeName" name="rcpe_name" type="text" placeholder="<?php esc_attr_e( 'Recipients Name', 'woofsubs' ) ?>">
				</div>
				<div class="input">
					<label for="yourName"><?php esc_html_e( 'Your Name', 'woofsubs' ) ?></label>
					<input id="yourName" name="your_name" type="text" placeholder="<?php esc_attr_e( 'Your Name', 'woofsubs' ) ?>">
				</div>
				<div class="input">
					<label for="message"><?php esc_html_e( 'Add handwritten message on the inside lid of the box', 'woofsubs' ) ?></label>
					<textarea id="message" name="message" rows="2"></textarea>
				</div>
			</div>
			<p class="section-err"></p>
		</section>
		<?php endif ?>
		<h3><?php esc_html_e( 'Dog\'s Subscription', 'woofsubs' ) ?></h3>
		<section class="sections text-center more-pad-bot wosu-footer">
			<nav class="text-center">
				<button data-href="#p"><i class="fas fa-arrow-left"></i></button>
				<button data-href="#f"><?php esc_html_e( 'Checkout', 'woofsubs' ) ?></button>
			</nav>
			<h3><?php
				// translators: %s => dog name
				printf( esc_html__( '%s\'s Subscription', 'woofsubs' ), '<span class="dog-name">' . esc_html( ucfirst( $dog_name ) ) . '</span>' );
			?></h3>
			<p class="section-desc"><?php esc_html_e( 'Make changes to the details below by clicking on them', 'woofsubs' ) ?></p>
			<div class="series">
				<div class="boxes full-width">
					<h4><?php esc_html_e( 'Pawsonle Information', 'woofsubs' ) ?></h4>
					<ul class="summary">
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Name', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="1"></i><br>
							<span id="dogNameF" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Gender', 'woofsubs' ) ?>:</span><br>
							<span id="dogGenderF" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Birthday', 'woofsubs' ) ?>:</span><br>
							<span id="dogMOBF" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Size', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="2"></i><br>
							<span id="dogSizeF" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Allergy', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="3"></i><br>
							<span id="dogAllergy" class="summary-field"></span>
						</li>
					</ul>
				</div>
				<div class="boxes full-width">
					<h4><?php esc_html_e( 'Subscription details', 'woofsubs' ) ?></h4>
					<ul class="summary">
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Crate', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="4"></i><br>
							<span id="pName" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Plan', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="5"></i><br>
							<span id="vName" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Price', 'woofsubs' ) ?>:</span><br>
							<span id="price" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Double Trouble', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="6"></i><br>
							<span id="douTro" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Extra Toy', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="7"></i><br>
							<span id="xToy" class="summary-field"></span>
						</li>
					</ul>
				</div>
				<?php if ( 'gift' === $mode ) : ?>
				<div class="boxes full-width">
					<h4><?php esc_html_e( 'Gift details', 'woofsubs' ) ?></h4>
					<ul class="summary">
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Recipients Name', 'woofsubs' ) ?>:</span>
							<i class="fas fa-edit" data-step="8"></i><br>
							<span id="giftReceive" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Your Name', 'woofsubs' ) ?>:</span><br>
							<span id="giftSend" class="summary-field"></span>
						</li>
						<li class="summary-item clearfix">
							<span class="summary-label"><?php esc_html_e( 'Message', 'woofsubs' ) ?>:</span><br>
							<span id="giftMessage" class="summary-field"></span>
						</li>
					</ul>
				</div>
				<?php endif ?>
			</div>
			<input id="dt" type="hidden" name="dou_tro" value="<?php echo esc_attr( $dou_tro[0] ) ?>">
		</section>
	</div>
</section>

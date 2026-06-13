<?php
/**
 * Template Name: Submit Property
 *
 * Auto-converted from submit-property.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'deposer-annonce-immobiliere-marrakech.webp' ) ); ?>);" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Déposer une annonce' ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php murailles_t( 'Déposez votre annonce' ); ?></h2>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Submit Property Start ================================== -->
			<section>
			
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
						
							<div class="alert alert-danger" role="alert">
								<p class="m-0"><?php murailles_t( 'Pas besoin de compte : remplissez le formulaire et notre équipe vous recontactera sous 24 h.' ); ?></p>
							</div>
						
						</div>
						
						<!-- Submit Form -->
						<div class="col-lg-12 col-md-12">
						
							<div class="submit-page p-0">

								<form class="murailles-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
									<input type="hidden" name="action" value="murailles_submit_property">
									<?php wp_nonce_field( 'murailles_submit_property', '_murailles_nonce' ); ?>
									<input type="hidden" name="_murailles_ts" value="<?php echo time(); ?>">
									<input type="hidden" name="page_url" value="<?php echo esc_url( get_permalink() ); ?>">
									<input type="hidden" name="language" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr' ); ?>">
									<input type="text" name="_mw_hp_url" value="" tabindex="-1" autocomplete="new-password" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;width:1px;height:1px;pointer-events:none;">
								<!-- Basic Information -->
								<div class="frm_submit_block">
									<h3><?php murailles_t( 'Informations générales' ); ?></h3>
									<div class="frm_submit_wrap">
										<div class="form-row row">

											<div class="form-group col-md-12">
												<label><?php murailles_t( "Titre de l'annonce" ); ?><a href="#" class="tip-topdata" data-tip="<?php echo esc_attr( murailles_t( "Titre de l'annonce", false ) ); ?>"><i class="ti-help"></i></a></label>
												<input type="text" name="property_title" class="form-control" required>
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Statut' ); ?></label>
												<select id="status" name="status" class="form-control">
													<option value="">&nbsp;</option>
													<option value="location"><?php murailles_t( 'À louer' ); ?></option>
													<option value="vente"><?php murailles_t( 'À vendre' ); ?></option>
												</select>
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Type de bien' ); ?></label>
												<select id="ptypes" name="ptypes" class="form-control">
													<option value="">&nbsp;</option>
													<option value="riad"><?php murailles_t( 'Riad' ); ?></option>
													<option value="appartement"><?php murailles_t( 'Appartement' ); ?></option>
													<option value="villa"><?php murailles_t( 'Villa' ); ?></option>
													<option value="terrain"><?php murailles_t( 'Terrain' ); ?></option>
													<option value="bureaux"><?php murailles_t( 'Bureaux' ); ?></option>
													<option value="commerce"><?php murailles_t( 'Commerce' ); ?></option>
												</select>
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Prix' ); ?></label>
												<input type="text" name="price" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Montant en €', false ) ); ?>">
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Surface (m²)' ); ?></label>
												<input type="text" name="area" class="form-control">
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Chambres' ); ?></label>
												<select id="bedrooms" name="bedrooms" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Salles de bain' ); ?></label>
												<select id="bathrooms" name="bathrooms" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>

										</div>
									</div>
								</div>
								
								<!-- Gallery -->
								<div class="frm_submit_block">
									<h3><?php murailles_t( 'Galerie photos' ); ?></h3>
									<div class="frm_submit_wrap">
										<div class="form-row row">

											<div class="form-group col-md-12">
												<label><?php murailles_t( 'Ajouter des photos' ); ?></label>
												<div class="murailles-uploader" data-murailles-uploader>
													<input type="file" name="gallery[]" id="murailles-gallery-input" accept="image/*" multiple class="murailles-uploader__input">
													<label for="murailles-gallery-input" class="murailles-uploader__drop">
														<svg class="murailles-uploader__icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
															<path d="M24 32V12"/>
															<polyline points="14,22 24,12 34,22"/>
															<path d="M8 36v2a4 4 0 0 0 4 4h24a4 4 0 0 0 4-4v-2"/>
														</svg>
														<span class="murailles-uploader__title"><?php murailles_t( 'Glissez vos photos ici ou cliquez pour parcourir' ); ?></span>
														<span class="murailles-uploader__hint"><?php murailles_t( 'JPG ou PNG — vous pouvez sélectionner plusieurs photos.' ); ?></span>
													</label>
													<div class="murailles-uploader__preview" data-murailles-uploader-preview></div>
												</div>
											</div>

										</div>
									</div>
								</div>
								
								<!-- Location -->
								<div class="frm_submit_block">
									<h3><?php murailles_t( 'Localisation' ); ?></h3>
									<div class="frm_submit_wrap">
										<div class="form-row row">

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Adresse' ); ?></label>
												<input type="text" name="address" class="form-control">
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Ville' ); ?></label>
												<select id="city" name="city" class="form-control">
													<option value="">&nbsp;</option>
													<option value="casablanca"><?php murailles_t( 'Casablanca' ); ?></option>
													<option value="marrakech"><?php murailles_t( 'Marrakech' ); ?></option>
													<option value="rabat"><?php murailles_t( 'Rabat' ); ?></option>
													<option value="tangier"><?php murailles_t( 'Tanger' ); ?></option>
													<option value="fes"><?php murailles_t( 'Fès' ); ?></option>
													<option value="agadir"><?php murailles_t( 'Agadir' ); ?></option>
												</select>
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Région' ); ?></label>
												<input type="text" name="state" class="form-control">
											</div>

											<div class="form-group col-md-6">
												<label><?php murailles_t( 'Code postal' ); ?></label>
												<input type="text" name="zip_code" class="form-control">
											</div>

										</div>
									</div>
								</div>
								
								<!-- Detailed Information -->
								<div class="frm_submit_block">
									<h3><?php murailles_t( 'Détails du bien' ); ?></h3>
									<div class="frm_submit_wrap">
										<div class="form-row row">

											<div class="form-group col-md-12">
												<label><?php murailles_t( 'Description' ); ?></label>
												<textarea name="description" class="form-control h-120"></textarea>
											</div>

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'Année de construction (facultatif)' ); ?></label>
												<select id="bage" name="building_age" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1"><?php murailles_t( '0 à 5 ans' ); ?></option>
													<option value="2"><?php murailles_t( '5 à 10 ans' ); ?></option>
													<option value="3"><?php murailles_t( '10 à 15 ans' ); ?></option>
													<option value="4"><?php murailles_t( '15 à 20 ans' ); ?></option>
													<option value="5"><?php murailles_t( 'Plus de 20 ans' ); ?></option>
												</select>
											</div>

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'Garage (facultatif)' ); ?></label>
												<select id="garage" name="garage" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'Pièces (facultatif)' ); ?></label>
												<select id="rooms" name="rooms" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>

											<div class="form-group col-md-12">
												<label><?php murailles_t( 'Équipements (facultatif)' ); ?></label>
												<div class="o-features">
													<ul class="no-ul-list third-row">
														<li>
															<input id="a-1" class="form-check-input" name="features[]" value="Climatisation" type="checkbox">
															<label for="a-1" class="form-check-label"><?php murailles_t( 'Climatisation' ); ?></label>
														</li>
														<li>
															<input id="a-2" class="form-check-input" name="features[]" value="Meublé" type="checkbox">
															<label for="a-2" class="form-check-label"><?php murailles_t( 'Meublé' ); ?></label>
														</li>
														<li>
															<input id="a-3" class="form-check-input" name="features[]" value="Chauffage" type="checkbox">
															<label for="a-3" class="form-check-label"><?php murailles_t( 'Chauffage' ); ?></label>
														</li>
														<li>
															<input id="a-4" class="form-check-input" name="features[]" value="Internet" type="checkbox">
															<label for="a-4" class="form-check-label"><?php murailles_t( 'Internet' ); ?></label>
														</li>
														<li>
															<input id="a-5" class="form-check-input" name="features[]" value="Cuisine équipée" type="checkbox">
															<label for="a-5" class="form-check-label"><?php murailles_t( 'Cuisine équipée' ); ?></label>
														</li>
														<li>
															<input id="a-6" class="form-check-input" name="features[]" value="Piscine" type="checkbox">
															<label for="a-6" class="form-check-label"><?php murailles_t( 'Piscine' ); ?></label>
														</li>
														<li>
															<input id="a-7" class="form-check-input" name="features[]" value="Terrasse" type="checkbox">
															<label for="a-7" class="form-check-label"><?php murailles_t( 'Terrasse' ); ?></label>
														</li>
														<li>
															<input id="a-8" class="form-check-input" name="features[]" value="Balcon" type="checkbox">
															<label for="a-8" class="form-check-label"><?php murailles_t( 'Balcon' ); ?></label>
														</li>
														<li>
															<input id="a-9" class="form-check-input" name="features[]" value="Jardin" type="checkbox">
															<label for="a-9" class="form-check-label"><?php murailles_t( 'Jardin' ); ?></label>
														</li>
														<li>
															<input id="a-10" class="form-check-input" name="features[]" value="Wi-Fi" type="checkbox">
															<label for="a-10" class="form-check-label"><?php murailles_t( 'Wi-Fi' ); ?></label>
														</li>
														<li>
															<input id="a-11" class="form-check-input" name="features[]" value="Vue mer" type="checkbox">
															<label for="a-11" class="form-check-label"><?php murailles_t( 'Vue mer' ); ?></label>
														</li>
														<li>
															<input id="a-12" class="form-check-input" name="features[]" value="Parking" type="checkbox">
															<label for="a-12" class="form-check-label"><?php murailles_t( 'Parking' ); ?></label>
														</li>
													</ul>
												</div>
											</div>

										</div>
									</div>
								</div>
								
								<!-- Contact Information -->
								<div class="frm_submit_block">
									<h3><?php murailles_t( 'Coordonnées' ); ?></h3>
									<div class="frm_submit_wrap">
										<div class="form-row row">

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'Nom complet' ); ?></label>
												<input type="text" name="contact_name" class="form-control" required>
											</div>

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'E-mail' ); ?></label>
												<input type="email" name="contact_email" class="form-control" required>
											</div>

											<div class="form-group col-md-4">
												<label><?php murailles_t( 'Téléphone (facultatif)' ); ?></label>
												<input type="tel" name="contact_phone" class="form-control">
											</div>

										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12 col-md-12">
									<button class="btn btn-danger" type="submit"><?php murailles_t( 'Soumettre mon annonce' ); ?></button>
									</div>
								</div>
								</form>											
							</div>
						</div>
						
					</div>
				</div>
						
			</section>
			<!-- ============================ Submit Property End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>

<div class="container">

	<div class="row justify-content-center mt-5">
		<div class="col-lg-10 py-4">

			<form class="contact-form" action="php/contact-form.php" method="POST">
				<div class="contact-form-success alert alert-success d-none mt-4">
					<strong>Success!</strong> Your message has been sent to us.
				</div>

				<div class="contact-form-error alert alert-danger d-none mt-4">
					<strong>Error!</strong> There was an error sending your message.
					<span class="mail-error-message text-1 d-block"></span>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<input type="text" placeholder="Your Name" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control form-control-lg py-3 text-3" name="name" id="name" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<input type="email" placeholder="Your E-mail" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control form-control-lg py-3 text-3" name="email" id="email" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<input type="text" placeholder="Subject" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control form-control-lg py-3 text-3" name="subject" id="subject" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<textarea maxlength="5000" placeholder="Message" data-msg-required="Please enter your message." rows="10" class="form-control form-control-lg py-3 text-3" name="message" id="message" required></textarea>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<input type="submit" value="Send Message" class="btn btn-outline btn-dark text-2 font-weight-semibold text-uppercase px-5 btn-py-3" data-loading-text="Loading...">
					</div>
				</div>
			</form>
		</div>

	</div>

</div>
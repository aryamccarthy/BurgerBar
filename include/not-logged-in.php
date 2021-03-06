<section id="login_section">
    <form id="login_form">
        <fieldset>
            <legend>Login</legend>
                <!--Pattern for noncompliant browsers from http://stackoverflow.com/questions/5601647/html5-email-input-pattern-attribute -->
                <input type="email" name="login_email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Email" required/>
                <input type="password" name="login_password" pattern=".{8,24}" placeholder="Password" required/>
        </fieldset>
        <input type="submit" style="visibility: hidden; position: absolute;" />
    </form>
</section>
<div class="container">
    <h1>Login</h1>
    <?php
    echo $this->Form->create();
    echo $this->Form->control('email', [
        'required' => true,
        'type' => 'email',
        'placeholder' => 'Email address'
    ]);
    echo $this->Form->password('password', [
        'placeholder' => 'Password'
    ]);
    echo $this->Form->submit('Submit');
    echo $this->Form->end() ?>
</div>
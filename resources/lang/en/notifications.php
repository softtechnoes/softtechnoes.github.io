<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notification Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during notifications for various
    | messages that we need to send to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    #UserRegisteredSuccessfully
    'UserRegisteredSuccessfully_email_subject'         => 'Welcome. Your account has been successfully created',
    'UserRegisteredSuccessfully_email_line_intro'      => 'You have been successfully registered to our system. Please activate your account / login.',
    'UserRegisteredSuccessfully_email_line_outro'      => 'We are delighted to welcome you as a user',
    'UserRegisteredSuccessfully_email_salutations'     => 'Regards',
    'UserRegisteredSuccessfully_db_title'              => 'Welcome. Your account has been successfully created',
    'UserRegisteredSuccessfully_db_detail'             => 'You have been successfully registered to our system',
    #InformUserRegistrationSuccessActivationPending
    'InformUserRegistrationSuccessActivationPending_email_subject'         => 'Welcome. Your account has been successfully created, activation pending',
    'InformUserRegistrationSuccessActivationPending_email_line_intro'      => 'You have been successfully registered to our system. Before you can login, your account has to be activated by an administrator.',
    'InformUserRegistrationSuccessActivationPending_email_line_outro'      => 'An administrator has been notified for your account activation',
    'InformUserRegistrationSuccessActivationPending_email_salutations'     => 'Regards',
    'InformUserRegistrationSuccessActivationPending_db_title'              => 'Welcome. Your account has been successfully created, activation pending',
    'InformUserRegistrationSuccessActivationPending_db_detail'             => 'You have been successfully registered to our system. Before you can login, your account has to be activated by an administrator',
    #UserRegisteredToAdmin
    'UserRegisteredToAdmin_email_subject'            => 'User account created successfully',
    'UserRegisteredToAdmin_email_line_intro'         => 'New account successfully created for the following user:',
    'UserRegisteredToAdmin_email_line_outro'         => 'If necessary, please check that its role (level of permissions for the usage of features) is adequate.',
    'UserRegisteredToAdmin_email_salutations'        => 'Regards',
    'UserRegisteredToAdmin_db_title'                 => 'User account created successfully',
    'UserRegisteredToAdmin_db_detail'                => 'New account successfully created for the following user:',
     #RequestUserActivationToAdmin
    'RequestUserActivationToAdmin_email_subject'            => 'Account activation request',
    'RequestUserActivationToAdmin_email_line_intro'         => 'The following user has requested its account to be activated:',
    'RequestUserActivationToAdmin_email_line_outro'         => 'Use any of the buttons to accept or deny the request.',
    'RequestUserActivationToAdmin_email_salutations'        => 'Regards',
    'RequestUserActivationToAdmin_db_title'                 => 'Account activation request',
    'RequestUserActivationToAdmin_db_detail'                => 'The following user has requested its account to be activated:',
    #RequestUserActivationAccepted
    'RequestUserActivationAccepted_email_subject'            => 'Account activation accepted',
    'RequestUserActivationAccepted_email_line_intro'         => 'Your request to activate your account has been accepted.',
    'RequestUserActivationAccepted_email_line_outro'         => 'You can now login to our system.',
    'RequestUserActivationAccepted_email_salutations'        => 'Regards',
    'RequestUserActivationAccepted_db_title'                 => 'Account activation accepted',
    'RequestUserActivationAccepted_db_detail'                => 'Your request to activate your account has been accepted. You can now login to our system.',
    #RequestAppAccessRefused
    'RequestUserActivationRefused_email_subject'            => 'Account activation refused',
    'RequestUserActivationRefused_email_line_intro'         => 'Your request to activate your account has been refused.',
    'RequestUserActivationRefused_email_line_outro'         => 'You can not login to our system.',
    'RequestUserActivationRefused_email_salutations'        => 'Regards',
    'RequestUserActivationRefused_db_title'                 => 'Account activation refused',
    'RequestUserActivationRefused_db_detail'                => 'Your request to activate your account has been refused. You can not login to our system.',
    #SupportRequestCreationToAdmin
    'SupportRequestCreationToAdmin_email_subject'     => 'New support request - Inventory',
    'SupportRequestCreationToAdmin_email_line_intro'  => 'Here is a new support request for the application',
    'SupportRequestCreationToAdmin_email_line_outro'  => 'Please get back to me as soon as possible',
    'SupportRequestCreationToAdmin_email_salutations' => 'Greetings',
]; 

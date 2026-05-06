<?php

return [
    'login_otp' => [
        'subject' => 'Your VertexGrad login verification code',
        'greeting' => 'Hello :name,',
        'line_1' => 'Use the verification code below to complete your login:',
        'line_2' => 'This code will expire in 10 minutes.',
        'line_3' => 'If you did not request this login, please ignore this email or secure your account.',
    ],

    'suspicious_login' => [
        'subject' => 'New login detected on your VertexGrad account',
        'greeting' => 'Hello :name,',
        'line_1' => 'We detected a new login to your VertexGrad account.',
        'ip' => 'IP address: :ip',
        'browser' => 'Browser: :browser',
        'os' => 'Operating system: :os',
        'device' => 'Device: :device',
        'line_2' => 'If this was you, no action is needed.',
        'line_3' => 'If this was not you, please change your password and review your account security.',
    ],
];
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Link</title>
    <!-- <link rel="stylesheet" href="<?php echo base_url() . '/css/vendor/bootstrap/bootstrap.min.css'; ?>"> -->
</head>
<body>
    <div style="max-width: 1140px;width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
        <div style="position: relative;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: .25rem;">
            <div style="flex: 1 1 auto;min-height: 1px;padding: 1.25rem;">
                <p style="margin-top: 0;margin-bottom: 1rem;">Welcome <?=$full_name?>,</p>
                <p style="margin-top: 0;margin-bottom: 1rem;">
                    Thanks for signing up with LEBS!<br>
                    You must follow this link to active your account:<br>
                    <a style="color: #007bff;text-decoration: none;background-color: transparent;" href="<?=$link?>" target="_blank"><?=$link?></a>
                </p style="margin-top: 0;margin-bottom: 1rem;">
                <p style="margin-top: 0;margin-bottom: 1rem;">Have fun learning english, and don't hesitate to contact us with your feedback.</p>
            </div>
        </div>
    </div>
    <!-- <script src="<?php echo base_url() . '/js/vendor/bootstrap/bootstrap.min.js'; ?>"></script> -->
</body>
</html>
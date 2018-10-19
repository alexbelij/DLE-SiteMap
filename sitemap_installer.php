<!DOCTYPE HTML>
<html>
    <head>
        <title>��������� ������ SiteMap</title>
        <link rel="stylesheet" type="text/css" href="http://store.alaev.info/style.css" />
        <style type="text/css">
            #header {width: 100%; text-align: center;}
            .module_image {float: left; margin: 0 15px 15px 0;}
            .box-cnt{width: 100%; overflow: hidden;}
        </style>
    </head>

    <body>
        <div class="wrap">
            <div id="header">
                <h1>SiteMap</h1>
            </div>
            <div class="box">
                <div class="box-t">&nbsp;</div>
                <div class="box-c">
                    <div class="box-cnt">
                        <?php

                            $output = module_installer();
                            echo $output;

                        ?>
                    </div>
                </div>
                <div class="box-b">&nbsp;</div>
            </div>
        </div>
    </body>
</html>

<?php

    function module_installer()
    {
        // ����������� �����
        $output = '<h2>����� ���������� � ���������� ������ SiteMap!</h2>';
        $output .= '<img class="module_image" src="/engine/skins/images/sitemap.png" />';
        $output .= '<p><strong>��������!</strong> ����� ��������� ������ <strong>�����������</strong> ������� ���� <strong>sitemap_installer.php</strong> � ������ �������!</p>';

        // ���� ����� $_POST ��������� �������� sitemap_install, ���������� �����������, �������� ����������
        if(!empty($_POST['sitemap_install']))
        {
            // ���������� config
            include_once ('engine/data/config.php');

            // ���������� DLE API
            include ('engine/api/api.class.php');

            // ������������� ������ � �������
            $dle_api->install_admin_module('sitemap', 'SiteMap - Html ����� �����', '������ ��� �������� Html ����� �����', 'sitemap.png');

            // �����
            $output .= '<p>';
            $output .= '������ ������� ����������! ������� �� ��� �����! �������� ������!';
            $output .= '</p>';
        }

        // ���� ����� $_POST ������ �� ���������, ������� ����� ��� ��������� ������
        else
        {
            // �����
            $output .= '<p>';
            $output .= '<form method="POST" action="sitemap_installer.php">';
            $output .= '<input type="hidden" name="sitemap_install" value="1" />';
            $output .= '<input type="submit" value="���������� ������" />';
            $output .= '</form>';
            $output .= '</p>';
        }
        
        $output .= '<p>';
        $output .= '<a href="http://alaev.info/blog/post/1974?from=SiteMapInstaller">���������� � ��������� ������</a>';
        $output .= '</p>';

        // ������� ���������� ��, ��� ������ ���� ��������
        return $output;
    }

?>
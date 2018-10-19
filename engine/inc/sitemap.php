<?php

/*
=============================================================================
 ����: sitemap.php (backend) ������ 2.2
-----------------------------------------------------------------------------
 �����: ����� ��������� ����������, mail@mithrandir.ru
-----------------------------------------------------------------------------
 ���� ���������: http://alaev.info/blog/post/1974
-----------------------------------------------------------------------------
 ����������: ��������� ���� ��� ������� ������ � ������ main.tpl
=============================================================================
*/

    // ���������
    if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
            die( "Hacking attempt!" );
    }

    echoheader('sitemap', '��������� ���� ��� ������� ������ � ������');
        echo '

'.($config['version_id'] >= 10.2 ? '<style>.uniform, div.selector {min-width: 250px;}</style>' : '<style>
@import url("engine/skins/application.css");

.box {
margin:10px;
}
.uniform {
position: relative;
padding-left: 5px;
overflow: hidden;
min-width: 250px;
font-size: 12px;
-webkit-border-radius: 0;
-moz-border-radius: 0;
-ms-border-radius: 0;
-o-border-radius: 0;
border-radius: 0;
background: whitesmoke;
background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi�pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==");
background-size: 100%;
background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #f5f5f5));
background-image: -webkit-linear-gradient(top, #ffffff, #f5f5f5);
background-image: -moz-linear-gradient(top, #ffffff, #f5f5f5);
background-image: -o-linear-gradient(top, #ffffff, #f5f5f5);
background-image: linear-gradient(top, #ffffff, #f5f5f5);
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
border: 1px solid #ccc;
font-size: 12px;
height: 28px;
line-height: 28px;
color: #666;
}
</style>').'

<div class="box">

	<div class="box-header">
		<div class="title">��������� ���� ��� ������� ������</div>
		<ul class="box-toolbar">
			<li class="toolbar-link">
			<a target="_blank" href="http://alaev.info/blog/post/1974?from=SiteMapAdmin">SiteMap v.2.2 � 2014 ���� ������\'� - ���������� � ��������� ������</a>
			</li>
		</ul>
	</div>

	<div class="box-content">
	<table class="table table-normal">
	<tbody>
		<tr>
		<td class="col-xs-6"><h5>���������� ���������:</h5><span class="note large">C����� id ��������� ����� ������� ��� ������ � �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_need_cats" id="sitemap_need_cats" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ���������:</h5><span class="note large">������ id ��������� ����� �������, ����������� �� �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_exc_cats" id="sitemap_exc_cats" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ������:</h5><span class="note large">C����� id ������ ����� ������� ��� ������ � �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_need_news" id="sitemap_need_news" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ������:</h5><span class="note large">������ id ������ ����� �������, ����������� �� �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_exc_news" id="sitemap_exc_news" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ����������� ��������:</h5><span class="note large">C����� id ����������� ������� ����� ������� ��� ������ � �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_need_static" id="sitemap_need_static" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ����������� ��������:</h5><span class="note large">������ id ����������� ������� ����� �������, ����������� �� �����.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_exc_static" id="sitemap_exc_static" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>�������� ��������� ��� ������:</h5><span class="note large">���������� �������� ��������� � ����� ����� �������� �� �� ��������.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="cats_as_links" id="sitemap_cats_as_links">
			<option value=""></option>
			<option value="1">��</option>
			<option value="0">���</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� � ����� ����������� ��������:</h5><span class="note large">���������� ����������� �������� � ������ ����� �����.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="show_static" id="sitemap_show_static">
			<option value=""></option>
			<option value="1">��</option>
			<option value="0">���</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ������ ���������:</h5><span class="note large">����, �� �������� �������� ������ ���� ������������� ��������� ��� ������ �����.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="cats_sort" id="sitemap_cats_sort">
			<option value=""></option>
			<option value="posi">�� �������������� �������</option>
			<option value="id">�� ���� ����������</option>
			<option value="name">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ����������:</h5><span class="note large">����������� ���������� ������ ���������.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="cats_msort" id="sitemap_cats_msort">
			<option value=""></option>
			<option value="ASC">�� �����������</option>
			<option value="DESC">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ������ ������:</h5><span class="note large">����, �� �������� �������� ������ ���� ������������� ������ ��� ������ �����.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="news_sort" id="sitemap_news_sort">
			<option value=""></option>
			<option value="id">�� ���� ����������</option>
			<option value="date">�� ���� ����������</option>
			<option value="title">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ����������:</h5><span class="note large">����������� ���������� ������ ������.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="news_msort" id="sitemap_news_msort">
			<option value=""></option>
			<option value="ASC">�� �����������</option>
			<option value="DESC">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ����������� �������:</h5><span class="note large">����, �� �������� �������� ������ ���� ������������� ����������� �������� ��� ������ �����.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="cats_sort" id="sitemap_static_sort">
			<option value=""></option>
			<option value="id">�� ���� ����������</option>
			<option value="name">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>����������� ����������:</h5><span class="note large">����������� ���������� ������ ����������� ������.</span></td>
		<td class="col-xs-6 settingstd">
			<select class="uniform" name="cats_msort" id="sitemap_static_msort">
			<option value=""></option>
			<option value="ASC">�� �����������</option>
			<option value="DESC">�� ��������</option>
			</select>
		</td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ������������:</h5><span class="note large">������������ ���������� ��������� ������������.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_cats_limit" id="sitemap_cats_limit" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ������:</h5><span class="note large">������������ ���������� ��������� ������.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_news_limit" id="sitemap_news_limit" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>���������� ����������� �������:</h5><span class="note large">������������ ���������� ��������� ����������� �������.</span></td>
		<td class="col-xs-6 settingstd"><input class="uniform" type="text" name="sitemap_static_limit" id="sitemap_static_limit" value="" /></td>
		</tr><tr>
		<td class="col-xs-6"><h5>��� ��� ������� � <strong>main.tpl</strong></h5><span class="note large"></span></td>
		<td class="col-xs-6 settingstd">
			<textarea type="text" style="width:100%;height:100px;" name="sitemap_code" id="sitemap_code" >{include file=\'engine/modules/sitemap.php\'}</textarea>
		</td>
		</tr>

                                <script type="text/javascript">
                                    var sitemap_options = [
                                         "need_cats",
                                         "exc_cats",
                                         "need_news",
                                         "exc_news",
                                         "need_static",
                                         "exc_static",
                                         "cats_as_links",
                                         "show_static",
                                         "cats_sort",
                                         "cats_msort",
                                         "news_sort",
                                         "news_msort",
                                         "static_sort",
                                         "static_msort",
                                         "cats_limit",
                                         "news_limit",
                                         "static_limit"
                                    ];

                                    for(i = 0; i < sitemap_options.length; i = i+1)
                                    {
                                        document.getElementById("sitemap_" + sitemap_options[i]).onchange = function(){recalculate_code()};
                                    }

                                    function recalculate_code()
                                    {

                                        document.getElementById("sitemap_code").value = "{include file=\'engine/modules/sitemap.php";

                                        for(var i = 0; i < sitemap_options.length; i = i+1)
                                        {
                                            if(document.getElementById("sitemap_" + sitemap_options[i]).value)
                                            {
                                                if(document.getElementById("sitemap_code").value == "{include file=\'engine/modules/sitemap.php")
                                                {
                                                    document.getElementById("sitemap_code").value = document.getElementById("sitemap_code").value + "?";
                                                }
                                                else
                                                {
                                                    document.getElementById("sitemap_code").value = document.getElementById("sitemap_code").value + "&";
                                                }
                                                document.getElementById("sitemap_code").value = document.getElementById("sitemap_code").value + sitemap_options[i] + "=" + document.getElementById("sitemap_" + sitemap_options[i]).value;
                                            }
                                        }

                                        document.getElementById("sitemap_code").value = document.getElementById("sitemap_code").value + "\'}";
                                    }
                                </script>
	</tbody>
	</table>
	</div>
</div>
        ';

        // ����������� ������� ���������� ����������
        echofooter();

?>
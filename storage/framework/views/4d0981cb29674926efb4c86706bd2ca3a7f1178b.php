.onoffswitch {
position: relative; width: 120px;
-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
display: none;
}
.onoffswitch-label {
display: block; overflow: hidden; cursor: pointer;
border: 2px solid #FFFFFF; border-radius: 50px;
}
.onoffswitch-inner {
display: block; width: 200%; margin-left: -100%;
transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
display: block; float: left; width: 50%; height: 29px; padding: 0; line-height: 29px;
font-size: 8px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
box-sizing: border-box;
}
.onoffswitch-inner:before {
content: "On";
padding-left: 8px;
background-color: #EEEEEE; color: #A1A1A1;
}
.onoffswitch-inner:after {
content: "OFF";
padding-right: 8px;
background-color: #EEEEEE; color: #999999;
text-align: right;
}
.onoffswitch-switch {
display: block; width: 39px; margin: -3px;
background: #A1A1A1;
position: absolute; top: 0; bottom: 0;
right: 89px;
border: 4px solid #FFFFFF; border-radius: 100px;
transition: all 0.3s ease-in 0s;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
right: 0px;
background-color: #0A6EBD;
}
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/output-css.blade.php ENDPATH**/ ?>
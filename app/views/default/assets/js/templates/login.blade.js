/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
// -------------------------------------------------------------------
var GG=GG||function(h,s){var f={},t=f.lib={},g=function(){},j=t.Base={extend:function(a){g.prototype=this;var c=new g;a&&c.mixIn(a);c.hasOwnProperty("init")||(c.init=function(){c.$super.init.apply(this,arguments)});c.init.prototype=c;c.$super=this;return c},create:function(){var a=this.extend();a.init.apply(a,arguments);return a},init:function(){},mixIn:function(a){for(var c in a)a.hasOwnProperty(c)&&(this[c]=a[c]);a.hasOwnProperty("toString")&&(this.toString=a.toString)},clone:function(){return this.init.prototype.extend(this)}},
q=t.WordArray=j.extend({init:function(a,c){a=this.words=a||[];this.sigBytes=c!=s?c:4*a.length},toString:function(a){return(a||u).stringify(this)},concat:function(a){var c=this.words,d=a.words,b=this.sigBytes;a=a.sigBytes;this.clamp();if(b%4)for(var e=0;e<a;e++)c[b+e>>>2]|=(d[e>>>2]>>>24-8*(e%4)&255)<<24-8*((b+e)%4);else if(65535<d.length)for(e=0;e<a;e+=4)c[b+e>>>2]=d[e>>>2];else c.push.apply(c,d);this.sigBytes+=a;return this},clamp:function(){var a=this.words,c=this.sigBytes;a[c>>>2]&=4294967295<<
32-8*(c%4);a.length=h.ceil(c/4)},clone:function(){var a=j.clone.call(this);a.words=this.words.slice(0);return a},random:function(a){for(var c=[],d=0;d<a;d+=4)c.push(4294967296*h.random()|0);return new q.init(c,a)}}),v=f.enc={},u=v.Hex={stringify:function(a){var c=a.words;a=a.sigBytes;for(var d=[],b=0;b<a;b++){var e=c[b>>>2]>>>24-8*(b%4)&255;d.push((e>>>4).toString(16));d.push((e&15).toString(16))}return d.join("")},parse:function(a){for(var c=a.length,d=[],b=0;b<c;b+=2)d[b>>>3]|=parseInt(a.substr(b,
2),16)<<24-4*(b%8);return new q.init(d,c/2)}},k=v.Latin1={stringify:function(a){var c=a.words;a=a.sigBytes;for(var d=[],b=0;b<a;b++)d.push(String.fromCharCode(c[b>>>2]>>>24-8*(b%4)&255));return d.join("")},parse:function(a){for(var c=a.length,d=[],b=0;b<c;b++)d[b>>>2]|=(a.charCodeAt(b)&255)<<24-8*(b%4);return new q.init(d,c)}},l=v.Utf8={stringify:function(a){try{return decodeURIComponent(escape(k.stringify(a)))}catch(c){throw Error("Malformed UTF-8 data");}},parse:function(a){return k.parse(unescape(encodeURIComponent(a)))}},
x=t.BufferedBlockAlgorithm=j.extend({reset:function(){this._data=new q.init;this._nDataBytes=0},_append:function(a){"string"==typeof a&&(a=l.parse(a));this._data.concat(a);this._nDataBytes+=a.sigBytes},_process:function(a){var c=this._data,d=c.words,b=c.sigBytes,e=this.blockSize,f=b/(4*e),f=a?h.ceil(f):h.max((f|0)-this._minBufferSize,0);a=f*e;b=h.min(4*a,b);if(a){for(var m=0;m<a;m+=e)this._doProcessBlock(d,m);m=d.splice(0,a);c.sigBytes-=b}return new q.init(m,b)},clone:function(){var a=j.clone.call(this);
a._data=this._data.clone();return a},_minBufferSize:0});t.Hasher=x.extend({cfg:j.extend(),init:function(a){this.cfg=this.cfg.extend(a);this.reset()},reset:function(){x.reset.call(this);this._doReset()},update:function(a){this._append(a);this._process();return this},finalize:function(a){a&&this._append(a);return this._doFinalize()},blockSize:16,_createHelper:function(a){return function(c,d){return(new a.init(d)).finalize(c)}},_createHmacHelper:function(a){return function(c,d){return(new w.HMAC.init(a,
d)).finalize(c)}}});var w=f.algo={};return f}(Math);
(function(h){for(var s=GG,f=s.lib,t=f.WordArray,g=f.Hasher,f=s.algo,j=[],q=[],v=function(a){return 4294967296*(a-(a|0))|0},u=2,k=0;64>k;){var l;a:{l=u;for(var x=h.sqrt(l),w=2;w<=x;w++)if(!(l%w)){l=!1;break a}l=!0}l&&(8>k&&(j[k]=v(h.pow(u,0.5))),q[k]=v(h.pow(u,1/3)),k++);u++}var a=[],f=f.SH=g.extend({_doReset:function(){this._hash=new t.init(j.slice(0))},_doProcessBlock:function(c,d){for(var b=this._hash.words,e=b[0],f=b[1],m=b[2],h=b[3],p=b[4],j=b[5],k=b[6],l=b[7],n=0;64>n;n++){if(16>n)a[n]=
c[d+n]|0;else{var r=a[n-15],g=a[n-2];a[n]=((r<<25|r>>>7)^(r<<14|r>>>18)^r>>>3)+a[n-7]+((g<<15|g>>>17)^(g<<13|g>>>19)^g>>>10)+a[n-16]}r=l+((p<<26|p>>>6)^(p<<21|p>>>11)^(p<<7|p>>>25))+(p&j^~p&k)+q[n]+a[n];g=((e<<30|e>>>2)^(e<<19|e>>>13)^(e<<10|e>>>22))+(e&f^e&m^f&m);l=k;k=j;j=p;p=h+r|0;h=m;m=f;f=e;e=r+g|0}b[0]=b[0]+e|0;b[1]=b[1]+f|0;b[2]=b[2]+m|0;b[3]=b[3]+h|0;b[4]=b[4]+p|0;b[5]=b[5]+j|0;b[6]=b[6]+k|0;b[7]=b[7]+l|0},_doFinalize:function(){var a=this._data,d=a.words,b=8*this._nDataBytes,e=8*a.sigBytes;
d[e>>>5]|=128<<24-e%32;d[(e+64>>>9<<4)+14]=h.floor(b/4294967296);d[(e+64>>>9<<4)+15]=b;a.sigBytes=4*d.length;this._process();return this._hash},clone:function(){var a=g.clone.call(this);a._hash=this._hash.clone();return a}});s.SH=g._createHelper(f);s.HmacSHA256=g._createHmacHelper(f)})(Math);
// --------------------------------------------------------------------
/*
End CryptoJS v3.1.2
*/

var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

$(function () {
	 getCaptcha();
});
$('#passwd').change(function(e){
	$('#login_token').val(GG.SH(e.target.value));
});
$('#signin').submit(function(e) {
	e.preventDefault();
	var formData = $(e.target).serializeArray();
	$.ajax({
		url: signin,
		type: 'post',
		data: formData,
		beforeSend: function() {
			$('#captcha-box').fadeOut();
			$('#preloading').fadeIn();
		},
		success: function(code) {
			if (code === '0') {
				getCaptcha();
				$('#preloading').fadeOut();
				$('#alert').fadeIn(function() {
					setTimeout(function() {
						$('#alert').fadeOut();
					}, 5000);
				});
			} else if (code === '1') {
				var redirect = '';
				var redirect_token = $('#redirect_token');
				if (redirect_token.length)
					redirect = Base64.decode(redirect_token.val());
				document.location.href = index + redirect;
			}
		}
	});
});
$('#reg_email').change(function(e) {
	$('input#reg_email').parent().attr('class','form-group');
	$('label[for="reg_email"]').html('Email :');
	$.ajax({
		url: check_user,
		type:'post',
		data: {
			email: e.target.value
		},
		success: function(code) {
			if (code === '0') {
				setTimeout(function() {
					$('input#reg_email').parent().attr('class','form-group has-error');
					$('label[for="reg_email"]').html('Email : อีเมลล์นี้มีผู้ใช้งานแล้ว');
				},200);
			};
		}
	});
});
$('#faculty').change(function(e) {
	if (e.target.value !== '0') {
		$('#faculty').fadeOut(function() {
			$.ajax({
				url: faculty_url + e.target.value,
				type: 'get',
				success: function(json) {
					var data = JSON.parse(json);
					$.each(data, function(index, value) {
						$('#major').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					$('#major-box').fadeIn();
				}
			});	
		});
	}
});
function getCaptcha() {
	$('#captcha-box').fadeOut(function() {
		// $('#captcha-box2').fadeOut();
		$.ajax({
			url: captcha_url + 'true',
			type: 'get',
			success: function(data) {
				$('#captcha-img').attr('src', data);
				$.ajax({
					url: captcha_url,
					type: 'get',
					success: function(json) {
						var btns = JSON.parse(json);
						$('#captcha-btn').empty();
						$.each(btns, function(index, value) {
							$('#captcha-btn').append('<button type="submit" class="btn btn-default col-xs-6" onclick="setCaptcha(this);" value="' + value + '">' + value + '</button>');
						});
						$('#captcha-box').fadeIn();
						$('#captcha-box2').html($('#captcha-box').html()); // .fadeIn();
						$('input#captcha').val('');
					}
				});
			}
		});
	});
}
$('#reg').submit(function(e) {
	var check = $('#reg_passwd').val() !== $('#reg_passwd_con').val();
	var check2 = $('#faculty').val() === '0';
	var check3 = $('#reg_email').parent().attr('class') === 'form-group has-error';
	$('#reg_passwd').parent().attr('class','form-group');
	$('#reg_passwd_con').parent().attr('class','form-group');
	$('#faculty').parent().attr('class','panel-heading');
	if (check) {
		e.preventDefault();
		setTimeout(function() {
			$('#reg_passwd').parent().attr('class','form-group has-error');
			$('#reg_passwd_con').parent().attr('class','form-group has-error');
		},200);
	} else if (check2) {
		e.preventDefault();
		setTimeout(function() {
			$('#faculty').parent().attr('class','panel-heading has-error');
		},200);
	} else if (check3) {
		e.preventDefault();
	}
});
function next2cap() {
	var body = $('.container');
	body.fadeOut(function() {
		$('#next').hide();
		$('#hidden-on-next').hide();
		$('#signin-section').hide();
		$('#register_token').val(GG.SH($('#reg_passwd_con').val()).toString());
		$('#captcha-box2').parent().show(function() {
			$('#register-section').attr('class', 'col-md-offset-3 col-md-6');
			body.fadeIn();
		});
	});
}
function setCaptcha(code) {
	$('input#captcha').val(code.value);
}
function changefaculty() {
	$('#major-box').fadeOut(function() {
		$('#major').empty();
		$('#faculty').fadeIn();
	});
}
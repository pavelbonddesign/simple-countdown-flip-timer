<?php
/*
 * Plugin Name: Simple Countdown Flip Timer
 * Author: Pavel Bondarchuk
 * Author URI: bonddesign.com.ua
 * Version: 1.0.0
 * Description: Simple countdown timer based on flipclock.js with shortcode [wpcountdown seconds="{by default: 900s}" msg="{by default: times end}"]
 */
function scft_function( $atts ) {
	extract( shortcode_atts( array(
		'seconds' => '900',
		'msg' => 'times end'
	), $atts ) );
	$random_heading_class = mt_rand();
	$random_clock_class = mt_rand();
	$random_msg_class = mt_rand();
	wp_register_script( 'js-countdown', plugin_dir_url( __FILE__ ) . '/flipclock.min.js' );
    wp_enqueue_script( 'js-countdown' );
	wp_register_style( 'css-countdown',  plugin_dir_url( __FILE__ ) . '/style.css' );
    wp_enqueue_style( 'css-countdown' );
	ob_start();
	?>
<div class="timer_block">
	<div class="timer_left timer_left<?php echo $random_heading_class; ?>">До конца акции осталось:</div>
	<div class="clock<?php echo $random_clock_class; ?>"></div>
    <div class="clock-msg"></div>
</div>
<script>
	jQuery(function ($) {
		$(document).ready(function () {
			$('.clock<?php echo $random_clock_class; ?>').each(function () {
				var clock;
				clock = $(".clock<?php echo $random_clock_class; ?>").FlipClock({
					clockFace: "MinuteCounter", //вид счетчика (с количеством дней)
					autoStart: true, //Отключаем автозапуск
					countdown: true, //Отсчет назад
					language: "ru-ru", //Локаль языка
					callbacks: {
						//Действие после окончания отсчета
						stop: function () {
							$(".clock<?php echo $random_clock_class; ?>").addClass(
								"hidden");
							$(".timer_left<?php echo $random_heading_class; ?>")
								.addClass("hidden");
							$(".clock-msg").html(
								"<?php echo $msg?>");
						}
					}
				})
				clock.setTime(<?php echo $seconds ?>); //Устанавливаем нужное время в секундах
				clock.setCountdown(true); //Устанавливаем отсчет назад
				clock.start(); //Запускаем отсчет
			})
		});
	});
</script>
<?php
	$return = ob_get_contents();
	ob_end_clean();
	
	return $return;
}
add_shortcode( 'wpcountdown', 'scft_function' );

?>
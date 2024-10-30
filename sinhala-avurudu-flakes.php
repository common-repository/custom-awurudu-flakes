<?php
/*
Plugin Name: Sinhala Avurudu Flakes
Description: Adds a simple falling awurudu flakes effect to your WordPress site using flakes spread all over the page.
Version: 1.1
Author: Uvindu Anuradha
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Hook to enqueue styles and scripts
function uvi_custom_awuruduflakes_enqueue_assets() {
    // Enqueue the main stylesheet (dummy handle for inline styles)
    wp_register_style('uvi-awuruduflakes-style', false);
    wp_enqueue_style('uvi-awuruduflakes-style');

    // Add inline CSS for awurudu flakes
    wp_add_inline_style('uvi-awuruduflakes-style', '
        body {
            margin: 0;
            overflow: auto; /* Allow scrolling */
        }
        .awuruduflake {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            background-size: contain;
            width: 30px; /* Adjust the size */
            height: 30px;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    ');

    // Enqueue jQuery (in case it's not already included)
    wp_enqueue_script('jquery');

    // Enqueue the awurudu flakes script
    wp_register_script('uvi-awuruduflakes-script', false, array('jquery'), null, true); // No external file, so using false
    wp_enqueue_script('uvi-awuruduflakes-script');

    // Add inline script for awurudu flakes
    wp_add_inline_script('uvi-awuruduflakes-script', '
        document.addEventListener("DOMContentLoaded", function() {
            const awuruduflakeCount = 50; // Number of awuruduflakes
            const awuruduflakes = [
                "' . esc_url(plugin_dir_url(__FILE__) . 'kokis.png') . '", 
                "' . esc_url(plugin_dir_url(__FILE__) . 'banana.png') . '", 
                "' . esc_url(plugin_dir_url(__FILE__) . 'asmi.png') . '", 
                "' . esc_url(plugin_dir_url(__FILE__) . 'aluwa.png') . '", 
                "' . esc_url(plugin_dir_url(__FILE__) . 'mung_kavum.png') . '", 
                "' . esc_url(plugin_dir_url(__FILE__) . 'seeni_murukku.png') . '"
            ]; // Snowflake images
            
            for (let i = 0; i < awuruduflakeCount; i++) {
                let awuruduflake = document.createElement("div");
                awuruduflake.classList.add("awuruduflake");
                awuruduflake.style.left = Math.random() * 100 + "vw";
                awuruduflake.style.top = Math.random() * 100 + "vh"; // Vary vertical start positions
                awuruduflake.style.animationDuration = Math.random() * 3 + 7 + "s"; // Vary fall duration
                awuruduflake.style.opacity = Math.random();
                awuruduflake.style.transform = `scale(${Math.random() * 0.5 + 0.5})`; // Vary size
                awuruduflake.style.backgroundImage = `url(${awuruduflakes[Math.floor(Math.random() * awuruduflakes.length)]})`;
                document.body.appendChild(awuruduflake);
            }
        });
    ');
}
add_action('wp_enqueue_scripts', 'uvi_custom_awuruduflakes_enqueue_assets');

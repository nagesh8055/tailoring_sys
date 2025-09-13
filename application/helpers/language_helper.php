<?php
function load_site_language() {
    $CI =& get_instance();

    // Get language from session or use default
    $language = $CI->session->userdata('site_lang') ? $CI->session->userdata('site_lang'): 'english';

    // Load language file dynamically
    $CI->lang->load('message', $language);
}
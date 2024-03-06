// Function to get current event start dates
function get_current_event_start_dates() {
    // Check if The Events Calendar is active
    if (class_exists('Tribe__Events__Main')) {
        // Get all events in the grid
        $events = tribe_get_events(array(
            'posts_per_page' => -1,
        ));

        // Check if there are any valid events
        if (!empty($events)) {
            $start_dates = array();

            // Iterate through each event and get the start date
            foreach ($events as $event) {
                $start_date = tribe_get_start_date($event, false, 'M j, Y');

                // Check if start date is not empty
                if (!empty($start_date)) {
                    $start_dates[] = $start_date;
                }
            }

            return $start_dates;
        }
    }

    return false; // Return false if no valid events are found or necessary functions are missing
}

// Shortcode to display current event start date
function display_current_event_start_date_shortcode() {
    static $index = 0; // Static variable to keep track of the index

    $start_dates = get_current_event_start_dates();

    if ($start_dates && isset($start_dates[$index])) {
        // Increment the index for the next shortcode call
        $index++;

        return $start_dates[$index - 1]; // Return the current start date
    } else {
        return 'No valid events found.';
    }
}

// Register the shortcode
if (function_exists('add_shortcode')) {
    add_shortcode('event_start_date', 'display_current_event_start_date_shortcode');
}

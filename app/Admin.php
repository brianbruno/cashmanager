<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 07/02/2018
 * Time: 21:05
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {
    // Import Notifiable Trait
    use Notifiable;
    // Specify Slack Webhook URL to route notifications to
    public function routeNotificationForSlack() {
        return 'https://hooks.slack.com/services/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';
    }
}
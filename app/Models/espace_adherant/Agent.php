namespace App\Models\espace_adherant;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['nom', 'signature_image', 'email', 'tel'];
}

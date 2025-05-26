use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user/by-wa/{wa}', [UserController::class, 'byWa']);
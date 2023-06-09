 <?php

use App\Http\Controllers\RevisorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

*/

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');
Route::get('/contattaci', [PublicController::class, 'contact_us'])->name('contact_us');
Route::get('/diventa-revisore', [PublicController::class, 'becomeRevisor'])->name('become-revisor');
Route::get('/chi-siamo', [PublicController::class, 'aboutUs'])->name('aboutUs');

// ROTTA LINGUA
Route::post('/lingua/{lang}', [PublicController::class, 'setLanguage'])->name('setLocale');
//ROTTA RICERCA 
Route::get('ricerca/articolo', [PublicController::class, 'searchArticle'])->name('articles.search');


// Rotte dei profili
Route::get('/profile/{user?}', [UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile/avatar/{user}', [UserController::class, 'changeAvatar'])->name('changeAvatar');
Route::get('/profile/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/profile/update/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy', [UserController::class, 'destroy'])->name('user.destroy');

// Rotte degli annunci
Route::get('/article/index', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
Route::get('/article/show/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/edit/{article}', [ArticleController::class, 'edit'])->name('article.edit');
Route::delete('/article/destroy/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

// Rotte delle categorie
Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->middleware('isAdmin')->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/show/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/category/edit/{category}', [CategoryController::class, 'edit'])->middleware('isAdmin')->name('category.edit');
Route::put('/category/update/{category}', [CategoryController::class, 'update'])->middleware('isAdmin')->name('category.update');
Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy'])->middleware('isAdmin')->name('category.destroy');


// ROTTA DEL REVISORE
Route::get('/revisor/home', [RevisorController::class, 'index'])->middleware('isRevisor')->name('revisor.index');
// accetta annuncio
Route::patch('/accetta/articolo/{article}', [RevisorController::class, 'acceptArticle'])->middleware('isRevisor')->name('revisor.accept_article');
// rifiuta annuncio
Route::patch('/rifiuta/articolo/{article}', [RevisorController::class, 'rejectArticle'])->middleware('isRevisor')->name('revisor.reject_article');
// ripristina annucio
Route::patch('/ripristina/articolo/{article}', [RevisorController::class, 'undoArticle'])->middleware('isRevisor')->name('revisor.undo_article');
// richiedi di diventare revisore
Route::get('/richiesta/revisore', [RevisorController::class, 'becomeRevisor'])->middleware('auth')->name('become.revisor');
// rendi utente revisore
Route::get('/richiesta/revisore{user}', [RevisorController::class, 'makeRevisor'])->name('make.revisor');
//Lista degli articoli (only moderator)
Route::get('/revisor/list', [ArticleController::class, 'listArticle'])->middleware('isRevisor')->name('revisor.list');

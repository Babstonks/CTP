<?php
namespace controllers;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;
 use Ubiquity\utils\http\USession;

 /**
  * Controller StoreController
  */
class StoreController extends \controllers\ControllerBase{
    private ViewRepository $repo;

    public function initialize() {
        $this->view->setVar("test", 0);
        parent::initialize();
        $this->repo??=new ViewRepository($this,Section::class);

    }

    #[Route('_default')]
	public function index(){
        $this->repo->all(condition: "",included: ["products"]);
        $count=DAO::count(Product::class);

        $this->loadView('StoreController/index.html', ['countProduct' => $count]);
	}

    #[Get(path: "store/section/{idSection}",name: "store.section")]
    public function section(int $idSection){
        $this->repo->byId($idSection, ['products']);
        $this->loadView('StoreController/section.html');
    }

    #[Get(path: "store/products",name: "store.products")]
    public function allProducts(){
        $count=DAO::getAll(Product::class);
        $this->loadView('StoreController/products.html', compact('count'));
    }

    #[Get(path: "store/addToCart/{idProduct}/{count}",name: "store.addToCart")]
    public function addToCart(int $idProduct, int $count){
        $session = USession::get($idProduct);
        $this->loadView('StoreController/addToCart.html');
    }

}

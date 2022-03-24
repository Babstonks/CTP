<?php
namespace controllers;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;

 /**
  * Controller StoreController
  */
class StoreController extends \controllers\ControllerBase{
    private ViewRepository $repo;

    public function initialize() {
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
        $this->loadView('StoreController/section.html');
    }
}

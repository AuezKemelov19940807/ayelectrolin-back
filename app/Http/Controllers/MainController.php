<?php

namespace App\Http\Controllers;

use App\Services\BannerService;
use App\Services\BrandService;
use App\Services\CompanyService;
use App\Services\ConsultationService;
use App\Services\EquipmentService;
use App\Services\GuaranteeService;
use App\Services\PriorityService;
use App\Services\ProjectService;
use App\Services\ReviewService;
use App\Services\SeoService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected BannerService $bannerService;

    protected EquipmentService $equipmentService;

    protected PriorityService $priorityService;

    protected GuaranteeService $guaranteeService;

    protected BrandService $brandService;

    protected ReviewService $reviewService;

    protected CompanyService $companyService;

    protected ProjectService $projectService;

    protected ConsultationService $consultationService;

    protected SeoService $seoService;

    public function __construct(
        BannerService $bannerService,
        EquipmentService $equipmentService,
        PriorityService $priorityService,
        GuaranteeService $guaranteeService,
        BrandService $brandService,
        ReviewService $reviewService,
        CompanyService $companyService,
        ProjectService $projectService,
        ConsultationService $consultationService,
        SeoService $seoService
    ) {
        $this->bannerService = $bannerService;
        $this->equipmentService = $equipmentService;
        $this->priorityService = $priorityService;
        $this->guaranteeService = $guaranteeService;
        $this->brandService = $brandService;
        $this->reviewService = $reviewService;
        $this->companyService = $companyService;
        $this->projectService = $projectService;
        $this->consultationService = $consultationService;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $banner = $this->bannerService->getBanner($lang);
        $equipment = $this->equipmentService->getEquipment($lang);
        $priority = $this->priorityService->getPriority($lang);
        $guarantee = $this->guaranteeService->getGuarantee($lang);
        $brand = $this->brandService->getBrand($lang);
        $review = $this->reviewService->getReview($lang);
        $company = $this->companyService->getCompany($lang);
        $project = $this->projectService->getProject($lang);
        $consultation = $this->consultationService->getConsultation($lang);
        $seo = $this->seoService->getSeo($lang);

        return response()->json([
            'banner' => $banner,
            'equipment' => $equipment,
            'priority' => $priority,
            'guarantee' => $guarantee,
            'brand' => $brand,
            'review' => $review,
            'company' => $company,
            'project' => $project,
            'consultation' => $consultation,
            'seo' => $seo,
        ]);
    }
}

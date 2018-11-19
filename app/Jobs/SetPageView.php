<?php

namespace App\Jobs;

use App\Logics\PageViewLogic;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SetPageView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var PageViewLogic
     */
    private $pageViewLogic;
    /**
     * @var string
     */
    private $urlName;
    /**
     * @var string
     */
    private $type;

    /**
     * Create a new job instance.
     *
     * @param PageViewLogic $pageViewLogic
     * @param string $urlName
     * @param string $type
     */
    public function __construct(PageViewLogic $pageViewLogic, string $urlName, string $type)
    {
        //
        $this->pageViewLogic = $pageViewLogic;
        $this->urlName = $urlName;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->pageViewLogic->setViewCount($this->urlName, $this->type);
    }
}

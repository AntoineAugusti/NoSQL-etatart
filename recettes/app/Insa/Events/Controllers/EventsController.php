<?php namespace Insa\Events\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\Factory as View;
use Insa\Events\Models\Event;
use Insa\Events\Repositories\EventsRepository;
use Insa\Events\Validation\EventValidator;

class EventsController extends Controller {

	/**
	 * @var EventsRepository
	 */
	private $eventsRepository;

	/**
	 * @var View
	 */
	private $view;
    /**
     * @var EventValidator
     */
    private $eventValidator;

    /**
     * The constructor
     * @param View $view
     * @param EventsRepository $eventsRepository
     * @param EventValidator $eventValidator
     */
	function __construct(View $view, EventsRepository $eventsRepository, EventValidator $eventValidator)
	{
		$this->view = $view;
		$this->eventsRepository = $eventsRepository;
        $this->eventValidator = $eventValidator;
    }

	/**
	 * List all events
	 * @return Response
	 */
	public function index()
	{
		$events = $this->eventsRepository->getAll();

		return $this->view->make('events.index', compact('events'));
	}

	/**
	 * Show the form to create a new event
	 * @return Response
	 */
	public function create()
	{
        $data = [
            'possibleTypes' => Event::getAllowedTypeValues()
        ];

		return $this->view->make('events.create', $data);
	}

	/**
	 * Store a new event
	 * @return Response
	 */
	public function store()
	{
        $data = Input::only('name', 'date', 'type');

        $this->eventValidator->validate($data);

		$data['date'] = $this->eventValidator->getValidatedDate($data['type'], $data['date']);
        $event = new Event($data);

        $this->eventsRepository->save($event);

        return Redirect::route('events.index');
	}
}
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
use Insa\Guests\Models\Guest;
use Insa\Guests\Repositories\GuestsRepository;
use Insa\Recipes\Repositories\RecipesRepository;

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
     * @var GuestsRepository
     */
    private $guestsRepository;
    /**
     * @var RecipesRepository
     */
    private $recipesRepository;

    /**
     * The constructor
     * @param View $view
     * @param EventsRepository $eventsRepository
     * @param EventValidator $eventValidator
     * @param GuestsRepository $guestsRepository
     * @param RecipesRepository $recipesRepository
     */
	function __construct(View $view, EventsRepository $eventsRepository, EventValidator $eventValidator, GuestsRepository $guestsRepository, RecipesRepository $recipesRepository)
	{
		$this->view = $view;
		$this->eventsRepository = $eventsRepository;
        $this->eventValidator = $eventValidator;
        $this->guestsRepository = $guestsRepository;
        $this->recipesRepository = $recipesRepository;
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
        $guests = [];
        foreach ($this->guestsRepository->getAll() as $guest) {
            $guests[$guest->id] = $guest->name;
        }

        $data = [
            'possibleTypes' => Event::getAllowedTypeValues(),
            'guests'        => $guests
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

        foreach (Input::get('guests') as $guestId) {
            $guest = $this->guestsRepository->getById($guestId);
            $this->guestsRepository->inviteIn($guest, $event);
        }

        return Redirect::route('events.index');
	}

    public function associate()
    {
        $recipe = $this->recipesRepository->getBySlug(Input::get('recipe'));
        $event = $this->eventsRepository->getById(Input::get('event'));

        $event->recipes()->attach($recipe->id);
        $event->save();

        return Redirect::route('recipes.show', $recipe->slug);
    }
}
<?php
class CacheCountryRepository implements CountryRepository {

  private $countries;

  public function __construct(CountryRepository $countries)
  {
    $this->countries = $countries;
  }

  /**
   * Récupère un pays en fonction de son ID
   * @param  integer $id
   * @return Country|null Le pays trouvé
   */
  public function getById($id)
  {
    $callback = (function() use ($id)
    {
      return $this->countries->getById($id);
    });

    return Cache::remember('countries.id-'.$id, 10, $callback);
  }
}
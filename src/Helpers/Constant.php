<?php

namespace iArcadia\MagicPokeAPI\Helpers;

/**
 * Gathers all constants.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Constant
{
    const REQUEST_CLASSES =
    [
        'curl' => 'CURL',
        'file' => 'File',
    ];
    
    const CACHE_CLASSES =
    [
        'file' => 'File',
    ];
    
    const RESOURCE_BERRY = 'berry';
    const RESOURCE_BERRY_FIRMNESS = 'berry-firmness';
    const RESOURCE_BERRY_FLAVOR = 'berry-flavor';
    const RESOURCE_CONTEST_TYPE = 'content-type';
    const RESOURCE_CONTEST_EFFECT = 'contest-effect';
    const RESOURCE_SUPER_CONTEST_EFFECT = 'super-contest-effect';
    const RESOURCE_ENCOUNTER_METHOD = 'encounter-method';
    const RESOURCE_ENCOUNTER_CONDITION = 'encounter-condition';
    const RESOURCE_ENCOUNTER_CONDITION_VALUE = 'encounter-condition-value';
    const RESOURCE_EVOLUTION_CHAIN = 'evolution-chain';
    const RESOURCE_EVOLUTION_TRIGGER = 'evolution-trigger';
    const RESOURCE_GENERATION = 'generation';
    const RESOURCE_POKEDEX = 'pokedex';
    const RESOURCE_VERSION = 'version';
    const RESOURCE_VERSION_GROUP = 'version-group';
    const RESOURCE_ITEM = 'item';
    const RESOURCE_ITEM_ATTRIBUTE = 'item-attribute';
    const RESOURCE_ITEM_CATEGORY = 'item-category';
    const RESOURCE_ITEM_FLING_EFFECT = 'item-fling-effect';
    const RESOURCE_ITEM_POCKET = 'item-pocket';
    const RESOURCE_MACHINE = 'machine';
    const RESOURCE_MOVE = 'move';
    const RESOURCE_MOVE_AILMENT = 'move-ailment';
    const RESOURCE_MOVE_BATTLE_STYLE = 'move-battle-style';
    const RESOURCE_MOVE_CATEGORY = 'move-category';
    const RESOURCE_MOVE_DAMAGE_CLASS = 'move-damage-class';
    const RESOURCE_MOVE_LEARN_METHOD = 'move-learn-method';
    const RESOURCE_MOVE_TARGET = 'move-target';
    const RESOURCE_LOCATION = 'location';
    const RESOURCE_LOCATION_AREA = 'location-area';
    const RESOURCE_PAL_PARK_AREA = 'pal-park-area';
    const RESOURCE_REGION = 'region';
    const RESOURCE_ABILITY = 'ability';
    const RESOURCE_CHARACTERISTIC = 'characteristic';
    const RESOURCE_EGG_GROUP = 'egg-group';
    const RESOURCE_GENDER = 'gender';
    const RESOURCE_GROWTH_RATE = 'growth-rate';
    const RESOURCE_NATURE = 'nature';
    const RESOURCE_POKEATHLON_STAT = 'pokeathlon-stat';
    const RESOURCE_POKEMON = 'pokemon';
    const RESOURCE_POKEMON_COLOR = 'pokemon-color';
    const RESOURCE_POKEMON_FORM = 'pokemon-form';
    const RESOURCE_POKEMON_HABITAT = 'pokemon-habitat';
    const RESOURCE_POKEMON_SHAPE = 'pokemon-shape';
    const RESOURCE_POKEMON_SPECIES = 'pokemon-species';
    const RESOURCE_STAT = 'stat';
    const RESOURCE_TYPE = 'type';
    const RESOURCE_LANGUAGE = 'language';
}
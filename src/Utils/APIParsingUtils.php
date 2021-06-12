<?php


namespace Flerex\SpainGas\Utils;


final class APIParsingUtils
{

    /**
     * The following words will always appear as they are typed. This ensures that they are not turned into
     * lowercase (or uppercase).
     *
     * @var array|string[] $fixed
     */
    private const FIXED = [
        'SA', 'SL', 'S.A.', 'S.L.', 'E.S.', 'ES', 'EESS', 'E.E.S.S.', 'EE.SS.', 'S.A.L.', 'S.C.A.',
        'CH2M', 'DGV', 'C.T.', 'U.S.', 'V.C.', 'CDT', 'R.R.', 'SCL', 'A.I.E.', 'BP', 'A.N.', 'U.S.Coop.',
        'J.A.', 'S.L',

        'SBC', 'HAM', 'EDP',

        'de', 'en', 'del', 'la', 'las', 'el', 'los'
    ];

    /**
     * By default the API provides all values as uppercase. This function allows us to transform
     * the uppercase names to a more human readable format.
     *
     * For example, the name REPSOL will turn to Repsol.
     *
     * @param string $name
     * @return string
     */
    public static function beautifyLabel(string $name): string
    {
        // Remove stylized names. |> Enertrix <| turns into Enertrix
        $name = preg_replace('/[<>|]/', '', $name);

        $name = trim($name);

        // Remove URL comma character (%2C).
        $name = preg_replace('/\%2c/i', '', $name);

        // Only one space allowed
        $name = preg_replace('/ +/', ' ', $name);

        // Replace `+` between words with spaces. Canso+carburants -> Canso carburants.
        $name = preg_replace('/\b\+\b/', ' ', $name);

        $name = ucwords(mb_strtolower($name));

        $name = array_reduce(self::FIXED, function(string $carry, string $item) {
            return preg_replace('/\b' . preg_quote($item) . '(?!\S)/i', $item, $carry);
        }, $name);

        // Ensure we start with capital letter if one of the prepositions was replaced at
        // the beginning. (del Olmo Hermanos -> Del Olmo Hermanos)
        $name = ucfirst($name);

        return $name;
    }
}

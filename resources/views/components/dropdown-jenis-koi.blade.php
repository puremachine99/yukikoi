@props(['name' => 'jenis_koi', 'multiple' => false, 'selected' => null])

<x-select :name="$name" :multiple="$multiple" {{ $attributes->merge(['class' => 'block w-full']) }}>
    <!-- Separator: Paling Populer -->
    <option disabled>--- Paling Populer ---</option>
    <option value="Kohaku" {{ $selected == 'Kohaku' ? 'selected' : '' }}>Kohaku</option>
    <option value="Asagi" {{ $selected == 'Asagi' ? 'selected' : '' }}>Asagi</option>
    <option value="Showa Sanshoku" {{ $selected == 'Showa Sanshoku' ? 'selected' : '' }}>Showa</option>
    <option value="Doitsu" {{ $selected == 'Doitsu' ? 'selected' : '' }}>Doitsu</option>
    <option value="Taisho Sanshoku" {{ $selected == 'Taisho Sanshoku' ? 'selected' : '' }}>Sanke (Taisho
        Sansoku)</option>
    <option value="Tancho" {{ $selected == 'Tancho' ? 'selected' : '' }}>Tancho</option>

    <!-- Separator: Varietas -->
    <option disabled>--- Varietas ---</option>
    <option value="Bekko" {{ $selected == 'Bekko' ? 'selected' : '' }}>Bekko</option>
    <option value="Goshiki" {{ $selected == 'Goshiki' ? 'selected' : '' }}>Goshiki</option>
    <option value="Koromo" {{ $selected == 'Koromo' ? 'selected' : '' }}>Koromo</option>
    <option value="Kujaku" {{ $selected == 'Kujaku' ? 'selected' : '' }}>Kujaku</option>
    <option value="Shiro Utsuri (Shiro)" {{ $selected == 'Shiro Utsuri (Shiro)' ? 'selected' : '' }}>Shiro Utsuri
        (Shiro)</option>
    <option value="Shusui" {{ $selected == 'Shusui' ? 'selected' : '' }}>Shusui</option>
    <option value="Ochiba" {{ $selected == 'Ochiba' ? 'selected' : '' }}>Ochiba</option>
    <option value="Hi/Ki Utsurimono" {{ $selected == 'Hi/Ki Utsurimono' ? 'selected' : '' }}>Hi/Ki Utsurimono</option>
    <option value="Hikari Moyomono" {{ $selected == 'Hikari Moyomono' ? 'selected' : '' }}>Hikari Moyomono</option>
    <option value="Hikari Mujimono" {{ $selected == 'Hikari Mujimono' ? 'selected' : '' }}>Hikari Mujimono</option>
    <option value="Hikari Utsurimono" {{ $selected == 'Hikari Utsurimono' ? 'selected' : '' }}>Hikari Utsurimono
    </option>
    <option value="Kawarimono A" {{ $selected == 'Kawarimono A' ? 'selected' : '' }}>Kawarimono A</option>
    <option value="Kawarimono B" {{ $selected == 'Kawarimono B' ? 'selected' : '' }}>Kawarimono B</option>
    <option value="Kinginrin A" {{ $selected == 'Kinginrin A' ? 'selected' : '' }}>Kinginrin A</option>
    <option value="Kinginrin B" {{ $selected == 'Kinginrin B' ? 'selected' : '' }}>Kinginrin B</option>
    <option value="Kinginrin C" {{ $selected == 'Kinginrin C' ? 'selected' : '' }}>Kinginrin C</option>

    <!-- Separator: Sub Varietas -->
    <option disabled>--- Sub Varietas ---</option>
    <option value="Shiro Bekko" {{ $selected == 'Shiro Bekko' ? 'selected' : '' }}>Shiro Bekko</option>
    <option value="Ki Bekko" {{ $selected == 'Ki Bekko' ? 'selected' : '' }}>Ki Bekko</option>
    <option value="Aka Bekko" {{ $selected == 'Aka Bekko' ? 'selected' : '' }}>Aka Bekko</option>
    <option value="Ai Goromo" {{ $selected == 'Ai Goromo' ? 'selected' : '' }}>Ai Goromo</option>
    <option value="Sumi Goromo" {{ $selected == 'Sumi Goromo' ? 'selected' : '' }}>Sumi Goromo</option>
    <option value="Budo Goromo" {{ $selected == 'Budo Goromo' ? 'selected' : '' }}>Budo Goromo</option>
    <option value="Tancho Kohaku" {{ $selected == 'Tancho Kohaku' ? 'selected' : '' }}>Tancho Kohaku</option>
    <option value="Tancho Sanke" {{ $selected == 'Tancho Sanke' ? 'selected' : '' }}>Tancho Sanke</option>
    <option value="Tancho Showa" {{ $selected == 'Tancho Showa' ? 'selected' : '' }}>Tancho Showa</option>

</x-select>
